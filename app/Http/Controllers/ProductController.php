<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        Log::info('ProductController@index: Request received.', $request->all());

        $sidebarMenuCategories = Category::whereNull('parent_id')
            ->where('is_visible', true)
            ->with([
                'children' => function ($queryLvl1) {
                    $queryLvl1->where('is_visible', true)->orderBy('sort_order')->orderBy('name')
                        ->with(['children' => function ($queryLvl2) {
                            $queryLvl2->where('is_visible', true)->orderBy('sort_order')->orderBy('name')
                                ->with(['children' => function ($queryLvl3) {
                                    $queryLvl3->where('is_visible', true)->orderBy('sort_order')->orderBy('name');
                                }]);
                        }]);
                }
            ])
            ->orderBy('sort_order')->orderBy('name')
            ->get();

        $selectedCategorySlug = $request->query('category');
        $selectedCategory = null;
        $categoryIdsToFilter = [];

        if ($selectedCategorySlug) {
            $selectedCategory = Category::where('slug', $selectedCategorySlug)
                ->where('is_visible', true)
                ->with('attributes')
                ->first();

            if ($selectedCategory) {
                $categoryIdsToFilter = $selectedCategory->getSelfAndVisibleDescendantsIds();
                Log::info("Selected Category: {$selectedCategory->name} (ID: {$selectedCategory->id}). Descendant IDs for filter:", $categoryIdsToFilter);
            } else {
                Log::info("Category with slug '{$selectedCategorySlug}' not found.");
                $selectedCategorySlug = null;
            }
        }

        $sortBy = $request->query('sort', 'created_at_desc');
        $selectedBrandSlugs = (array) $request->query('brands', []);
        $minPriceRequest = $request->query('min_price');
        $maxPriceRequest = $request->query('max_price');
        $availability = $request->query('availability');
        $isNewRequest = $request->query('is_new') == '1';

        $productsQuery = Product::query()->where('is_visible', true);

        if (!empty($categoryIdsToFilter)) $productsQuery->whereIn('category_id', $categoryIdsToFilter);
        if (!empty($selectedBrandSlugs)) $productsQuery->whereHas('brand', fn($q) => $q->whereIn('slug', $selectedBrandSlugs)->where('is_visible', true));
        if ($availability === 'in_stock') $productsQuery->where('quantity', '>', 0);
        elseif ($availability === 'out_of_stock') $productsQuery->where(fn($q) => $q->where('quantity', '<=', 0)->orWhereNull('quantity'));
        if ($isNewRequest) $productsQuery->where('is_new', true);

        $availableSpecificFiltersData = [];
        $activeDynamicFiltersConfig = [];
        $allDynamicFilterKeys = [];

        if ($selectedCategory && $selectedCategory->attributes->isNotEmpty()) {
            Log::info("Processing attributes for category: {$selectedCategory->name}. Total attributes linked initially: " . $selectedCategory->attributes->count());
            $categoryAttributes = $selectedCategory->attributes()->where('is_filterable', true)->orderBy('pivot_sort_order')->get();
            Log::info("Filterable attributes for {$selectedCategory->name}: " . $categoryAttributes->count(), $categoryAttributes->pluck('name', 'slug')->all());

            foreach ($categoryAttributes as $attribute) {
                $filterRequestKey = 'attr_' . $attribute->slug;
                $allDynamicFilterKeys[] = $filterRequestKey;
                $valueColumn = $this->getValueColumnForAttributeType($attribute->type);

                if (!$valueColumn) {
                    Log::warning("ProductController: Unsupported type '{$attribute->type}' for '{$attribute->name}'. Skipping filter options.");
                    continue;
                }
                Log::debug("Filter options for attribute: {$attribute->name} (Type: {$attribute->type}, Col: {$valueColumn})");

                $optionsQueryContextForThisAttribute = Product::query()->where('is_visible', true);
                if (!empty($categoryIdsToFilter)) $optionsQueryContextForThisAttribute->whereIn('category_id', $categoryIdsToFilter);
                if (!empty($selectedBrandSlugs)) $optionsQueryContextForThisAttribute->whereHas('brand', fn($q) => $q->whereIn('slug', $selectedBrandSlugs));
                if ($availability === 'in_stock') $optionsQueryContextForThisAttribute->where('quantity', '>', 0);
                elseif ($availability === 'out_of_stock') $optionsQueryContextForThisAttribute->where(fn($q) => $q->where('quantity', '<=',0)->orWhereNull('quantity'));
                if ($isNewRequest) $optionsQueryContextForThisAttribute->where('is_new', true);
                $tempMin = $request->query('min_price'); $tempMax = $request->query('max_price');
                if ($tempMin !== null && is_numeric($tempMin)) $optionsQueryContextForThisAttribute->where(DB::raw('COALESCE(sale_price, price)'), '>=', (float)$tempMin);
                if ($tempMax !== null && is_numeric($tempMax)) $optionsQueryContextForThisAttribute->where(DB::raw('COALESCE(sale_price, price)'), '<=', (float)$tempMax);

                foreach ($categoryAttributes as $otherAttr) {
                    if ($otherAttr->id === $attribute->id) continue;
                    $otherKey = 'attr_' . $otherAttr->slug; $otherVal = $request->input($otherKey);
                    $otherCol = $this->getValueColumnForAttributeType($otherAttr->type);
                    if ($otherVal !== null && $otherVal !== '' && $otherCol) {
                        $optionsQueryContextForThisAttribute->whereHas('attributeValues', function (Builder $q) use ($otherAttr, $otherVal, $otherCol) {
                            $q->where('attribute_id', $otherAttr->id);
                            if (is_array($otherVal)) { $c = array_filter($otherVal, fn($v)=>$v!==null&&$v!==''); if(!empty($c)) $q->whereIn($otherCol, $c); }
                            else { $q->where($otherCol, $otherVal); }
                        });
                    }
                }

                $dbOptionsQuery = $optionsQueryContextForThisAttribute
                    ->join('product_attribute_values as pav', 'products.id', '=', 'pav.product_id')
                    ->where('pav.attribute_id', $attribute->id)
                    ->whereNotNull('pav.' . $valueColumn);

                if (in_array(strtolower($attribute->type), ['integer', 'decimal', 'number', 'float'])) {
                    if (config('database.default') === 'pgsql') {
                        // For PostgreSQL, include the ordering expression in the SELECT for DISTINCT
                        // And use orderByRaw for the full custom ordering clause
                        $numericSortExpression = "NULLIF(REGEXP_REPLACE(pav.{$valueColumn}::text, '[^0-9.-]+', '', 'g'), '')::numeric";
                        $dbOptionsQuery->selectRaw("pav.{$valueColumn} as option_value, {$numericSortExpression} as sort_key_for_pg")
                            ->distinct() // Distinct on both selected columns
                            // Use orderByRaw for the full custom ordering clause
                            ->orderByRaw("sort_key_for_pg ASC NULLS LAST");
                    } elseif (config('database.default') === 'mysql') {
                        $dbOptionsQuery->select("pav.{$valueColumn} as option_value")
                            ->distinct()
                            ->orderByRaw("CAST(pav.{$valueColumn} AS DECIMAL(10,2)) ASC");
                    } else {
                        // Fallback for other databases
                        $dbOptionsQuery->select("pav.{$valueColumn} as option_value")
                            ->distinct()
                            ->orderBy("pav.{$valueColumn}", 'asc'); // Explicitly 'asc'
                    }
                } else {
                    // For non-numeric types
                    $dbOptionsQuery->select("pav.{$valueColumn} as option_value")
                        ->distinct()
                        ->orderBy("option_value", 'asc'); // Explicitly 'asc' for the alias
                }
                $optionsFromProducts = $dbOptionsQuery->pluck('option_value');
                Log::debug("Options from products for '{$attribute->name}' (DB Driver: " . config('database.default') . "):", $optionsFromProducts->all());


                $finalOptionsSource = $optionsFromProducts;
                if ($optionsFromProducts->isEmpty() && !empty($attribute->options) && $this->mapAttributeTypeToFilterInputType($attribute->type, $attribute->options) === 'select') {
                    Log::debug("  '{$attribute->name}' has no product options, using defined options for select.", $attribute->options);
                    $finalOptionsSource = collect(is_array($attribute->options) && !isset($attribute->options[0]) ? array_keys($attribute->options) : $attribute->options);
                }

                if ($finalOptionsSource->isEmpty()){ Log::debug("Skipping filter '{$attribute->name}': no options."); continue; }

                $formattedOptions = $finalOptionsSource->mapWithKeys(function ($optVal) use ($attribute) {
                    $label = (string) $optVal;
                    if (is_array($attribute->options) && !empty($attribute->options) && array_key_exists((string)$optVal, $attribute->options)) {
                        $label = $attribute->options[(string)$optVal];
                    }
                    if ($attribute->unit && is_string($label) && !Str::endsWith($label,$attribute->unit) && !Str::startsWith($label,$attribute->unit)) {
                        $label .= ' '.$attribute->unit;
                    }
                    return [(string)$optVal => $label];
                })->filter()->all();

                // Sort formatted options numerically if the original type was numeric
                if (in_array(strtolower($attribute->type), ['integer','decimal','number','float'])) {
                    uksort($formattedOptions, function($a, $b) {
                        $numA = preg_replace("/[^0-9.-]/", "", $a);
                        $numB = preg_replace("/[^0-9.-]/", "", $b);
                        if (is_numeric($numA) && is_numeric($numB)) {
                            return (float)$numA <=> (float)$numB;
                        }
                        return strnatcmp((string)$a, (string)$b); // Fallback to natural string sort
                    });
                }

                if (!empty($formattedOptions)) {
                    Log::debug("Adding '{$attribute->name}' to available filters.", ['key' => $filterRequestKey, 'options_count' => count($formattedOptions)]);
                    $availableSpecificFiltersData[$filterRequestKey] = [
                        'label' => $attribute->name, 'type' => $this->mapAttributeTypeToFilterInputType($attribute->type, $attribute->options),
                        'options' => $formattedOptions, 'defined_options' => $attribute->options,
                        'request_key' => $filterRequestKey, 'unit' => $attribute->unit,
                    ];
                } else { Log::debug("No formatted options for '{$attribute->name}', not adding filter."); }

                $requestValue = $request->input($filterRequestKey);
                if ($requestValue !== null && $requestValue !== '') {
                    Log::debug("Applying filter '{$attribute->name}' to main query with value:", ['value' => $requestValue]);
                    $activeDynamicFiltersConfig[$filterRequestKey] = [
                        'label' => $attribute->name, 'options' => $formattedOptions, // Use formatted for summary
                        'type' => $this->mapAttributeTypeToFilterInputType($attribute->type, $attribute->options),
                        'unit' => $attribute->unit,
                    ];
                    $productsQuery->whereHas('attributeValues', function (Builder $q) use ($attribute, $requestValue, $valueColumn) {
                        $q->where('attribute_id', $attribute->id);
                        if (is_array($requestValue)) { $c=array_filter($requestValue,fn($v)=>$v!==null&&$v!==''); if(!empty($c)) $q->whereIn($valueColumn, $c); }
                        else { $q->where($valueColumn, $requestValue); }
                    });
                }
            }
        } else { Log::info($selectedCategory ? "Category '{$selectedCategory->name}' has no filterable attributes (or attributes at all)." : "No category selected, dynamic filters skipped."); }

        $priceContextOverall = Product::query()->where('is_visible', true);
        if(!empty($categoryIdsToFilter)) $priceContextOverall->whereIn('category_id', $categoryIdsToFilter);
        $overallMinPrice = floor($priceContextOverall->min(DB::raw('COALESCE(sale_price, price)')) ?? 0);
        $overallMaxPrice = ceil($priceContextOverall->max(DB::raw('COALESCE(sale_price, price)')) ?? 1000);
        if ($overallMinPrice == $overallMaxPrice && $overallMaxPrice > 0) { $overallMinPrice = max(0, floor($overallMinPrice*0.85)); $overallMaxPrice = ceil($overallMaxPrice*1.15); }
        elseif ($overallMinPrice >= $overallMaxPrice) { $tempMax = $overallMaxPrice; $overallMinPrice = $tempMax > 0 ? max(0, floor($tempMax*0.85)) : 0; if($tempMax==0 && $overallMinPrice==0) $overallMaxPrice=1000; else if($tempMax==0) $overallMaxPrice = $overallMinPrice > 0 ? $overallMinPrice+100 : 1000; else $overallMaxPrice = ceil($tempMax*1.15); }
        if ($overallMinPrice > $overallMaxPrice && $overallMaxPrice > 0) $overallMinPrice = floor($overallMaxPrice*0.9); elseif ($overallMinPrice > $overallMaxPrice && $overallMaxPrice==0) { $overallMinPrice=0; $overallMaxPrice=100;} if ($overallMinPrice == $overallMaxPrice && $overallMinPrice >= 0) $overallMaxPrice = $overallMinPrice + max(100, floor($overallMinPrice*0.1));


        if ($minPriceRequest !== null && is_numeric($minPriceRequest)) $productsQuery->where(DB::raw('COALESCE(sale_price, price)'), '>=', (float)$minPriceRequest);
        if ($maxPriceRequest !== null && is_numeric($maxPriceRequest)) $productsQuery->where(DB::raw('COALESCE(sale_price, price)'), '<=', (float)$maxPriceRequest);

        switch ($sortBy) {
            case 'name_asc': $productsQuery->orderBy('name', 'asc'); break; // Correct
            case 'name_desc': $productsQuery->orderBy('name', 'desc'); break; // Correct
            case 'price_asc': $productsQuery->orderBy(DB::raw('COALESCE(sale_price, price)'), 'asc'); break; // Correct
            case 'price_desc': $productsQuery->orderBy(DB::raw('COALESCE(sale_price, price)'), 'desc'); break; // Correct
            case 'created_at_asc': $productsQuery->orderBy('created_at', 'asc'); break; // Correct
            default: $productsQuery->orderBy('created_at', 'desc'); break; // Correct
        }
        $products = $productsQuery->with(['category', 'brand'])->paginate(12)->appends($request->query());
        Log::info("Final product count after all filters: " . $products->total());

        $sortOptions = [
            'created_at_desc' => 'Сначала новые', 'created_at_asc' => 'Сначала старые',
            'price_asc' => 'Сначала дешевые', 'price_desc' => 'Сначала дорогие',
            'name_asc' => 'Название (А → Я)', 'name_desc' => 'Название (Я → А)',
        ];
        $brandsContextQuery = Product::query()->where('is_visible', true)->whereNotNull('brand_id');
        if (!empty($categoryIdsToFilter)) $brandsContextQuery->whereIn('category_id', $categoryIdsToFilter);
        if ($availability === 'in_stock') $brandsContextQuery->where('quantity', '>', 0); elseif ($availability === 'out_of_stock') $brandsContextQuery->where(fn($q)=>$q->where('quantity','<=',0)->orWhereNull('quantity'));
        if ($isNewRequest) $brandsContextQuery->where('is_new', true);
        if ($minPriceRequest !== null && is_numeric($minPriceRequest)) $brandsContextQuery->where(DB::raw('COALESCE(sale_price, price)'), '>=', (float)$minPriceRequest);
        if ($maxPriceRequest !== null && is_numeric($maxPriceRequest)) $brandsContextQuery->where(DB::raw('COALESCE(sale_price, price)'), '<=', (float)$maxPriceRequest);
        if ($selectedCategory && $selectedCategory->attributes->isNotEmpty()){
            $catAttrsForBrand = $selectedCategory->attributes()->where('is_filterable', true)->get(); // Re-fetch or use previously fetched $categoryAttributes
            foreach ($catAttrsForBrand as $attrForBrand) {
                $key = 'attr_' . $attrForBrand->slug; $val = $request->input($key);
                $col = $this->getValueColumnForAttributeType($attrForBrand->type);
                if ($val !== null && $val !== '' && $col) {
                    $brandsContextQuery->whereHas('attributeValues', function (Builder $q) use ($attrForBrand, $val, $col) {
                        $q->where('attribute_id', $attrForBrand->id);
                        if(is_array($val)){ $c=array_filter($val,fn($v)=>$v!==null&&$v!==''); if(!empty($c)) $q->whereIn($col,$c); }
                        else { $q->where($col,$val); }
                    });
                }
            }
        }

        $availableBrandIds = $brandsContextQuery->distinct()->pluck('brand_id');
        $availableBrands = Brand::whereIn('id', $availableBrandIds)->where('is_visible', true)->orderBy('name')->get();

        $currentMinPrice = ($minPriceRequest !== null && is_numeric($minPriceRequest)) ? (float)$minPriceRequest : $overallMinPrice;
        $currentMaxPrice = ($maxPriceRequest !== null && is_numeric($maxPriceRequest)) ? (float)$maxPriceRequest : $overallMaxPrice;

        return view('catalog.index', [
            'products' => $products, 'categories' => $sidebarMenuCategories,
            'selectedCategorySlug' => $selectedCategorySlug, 'selectedCategory' => $selectedCategory,
            'sortBy' => $sortBy, 'sortOptions' => $sortOptions,
            'availableBrands' => $availableBrands, 'selectedBrandSlugs' => $selectedBrandSlugs,
            'overallMinPrice' => $overallMinPrice, 'overallMaxPrice' => $overallMaxPrice,
            'currentMinPrice' => $currentMinPrice, 'currentMaxPrice' => $currentMaxPrice,
            'availability' => $availability, 'request' => $request, 'isNewRequest' => $isNewRequest,
            'availableSpecificFiltersData' => $availableSpecificFiltersData,
            'activeDynamicFiltersConfig' => $activeDynamicFiltersConfig,
            'allDynamicFilterKeys' => $allDynamicFilterKeys,
        ]);
    }

    private function getValueColumnForAttributeType(string $attributeType): ?string
    {
        return match (strtolower($attributeType)) {
            'text', 'textarea', 'select', 'resolution', 'matrix_type', 'cpu_type', 'os_type', 'color', 'ram_type', 'gpu_type', 'connection_type', 'interface', 'sensor_type', 'backlight', 'string', 'ports_video', 'aspect_ratio', 'contrast_ratio', 'hdr_support', 'keyboard_type', 'switch_type', 'network_support', 'main_camera_mp', 'cpu_model', 'gpu_model', 'storage_type', 'cpu_series', 'gpu_manufacturer', 'material', 'dimensions' => 'text_value',
            'integer', 'number', 'ram_size', 'ssd_volume', 'hdd_volume', 'refresh_rate', 'cpu_cores', 'gpu_memory', 'buttons_count', 'max_speed_ips', 'max_acceleration_g', 'dpi', 'response_time', 'brightness', 'front_camera_mp', 'battery_capacity', 'warranty' => 'integer_value',
            'decimal', 'screen_size', 'float', 'weight_kg' => 'decimal_value',
            'boolean', 'checkbox', 'touchscreen', 'nfc_support' => 'boolean_value',
            'date' => 'date_value',
            'datetime' => 'datetime_value',
            default => 'text_value', // Fallback, should log if this is hit unexpectedly
        };
    }

    private function mapAttributeTypeToFilterInputType(string $attributeType, ?array $definedOptions = []): string
    {
        $hasDefinedOptions = !empty($definedOptions);
        $attributeTypeLower = strtolower($attributeType);

        if ($attributeTypeLower === 'select') {
            return ($hasDefinedOptions && count($definedOptions) > 0) ? 'select' : 'checkbox';
        }
        if ($attributeTypeLower === 'boolean') return 'single_checkbox';

        $checkboxThreshold = 7; // Configurable: if more options than this, use select
        if ($hasDefinedOptions && count($definedOptions) > $checkboxThreshold) {
            return 'select';
        }
        if ($hasDefinedOptions && count($definedOptions) > 0) { // Fewer defined options, checkbox is fine
            return 'checkbox';
        }
        // Default for types where options are mainly derived from product values (text, number, decimal)
        return 'checkbox';
    }

    public function show(string $slug): View
    {
        $product = Product::where('slug', $slug)
            ->where('is_visible', true)
            ->with([
                'category.attributes' => function ($query) {
                    $query->orderBy('pivot_sort_order');
                },
                'brand',
                'MappedAttributes', // Correct: Eager load Attribute models via pivot
                'reviews'
            ])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_visible', true)->with('brand')->inRandomOrder()->take(4)->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }
}
