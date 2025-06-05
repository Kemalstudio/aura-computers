<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $sidebarMenuCategories = Category::whereNull('parent_id')
            ->where('is_visible', true)
            ->with([
                'children' => function ($queryLvl1) {
                    $queryLvl1->where('is_visible', true)
                        ->orderBy('name')
                        ->with(['children' => function ($queryLvl2) {
                            $queryLvl2->where('is_visible', true)
                                ->orderBy('name')
                                ->with(['children' => function ($queryLvl3) {
                                    $queryLvl3->where('is_visible', true)->orderBy('name');
                                }]);
                        }]);
                }
            ])
            ->orderBy('name')
            ->get();

        $selectedCategorySlug = $request->query('category');
        $selectedCategory = null;
        $categoryIdsToFilter = [];

        if ($selectedCategorySlug) {
            $selectedCategory = Category::where('slug', $selectedCategorySlug)
                ->where('is_visible', true)
                ->first();

            if ($selectedCategory) {
                $categoryIdsToFilter = $selectedCategory->getSelfAndVisibleDescendantsIds();
            } else {
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

        if (!empty($categoryIdsToFilter)) {
            $productsQuery->whereIn('category_id', $categoryIdsToFilter);
        }

        if (!empty($selectedBrandSlugs)) {
            $productsQuery->whereHas('brand', function ($query) use ($selectedBrandSlugs) {
                $query->whereIn('slug', $selectedBrandSlugs)->where('is_visible', true);
            });
        }

        if ($availability === 'in_stock') {
            $productsQuery->where('quantity', '>', 0);
        } elseif ($availability === 'out_of_stock') {
            $productsQuery->where(function ($query) {
                $query->where('quantity', '<=', 0)->orWhereNull('quantity');
            });
        }

        if ($isNewRequest) {
            $productsQuery->where('is_new', true);
        }

        $currentCategorySlugForSpecificFilters = $selectedCategory ? $selectedCategory->slug : null;

        $activeSpecificFiltersConfig = $this->getSpecificFiltersConfigForCategory($currentCategorySlugForSpecificFilters);
        $availableSpecificFiltersData = [];

        $optionsQueryContextBase = Product::query()->where('is_visible', true);
        if (!empty($categoryIdsToFilter)) {
            $optionsQueryContextBase->whereIn('category_id', $categoryIdsToFilter);
        }
        if (!empty($selectedBrandSlugs)) {
            $optionsQueryContextBase->whereHas('brand', function ($query) use ($selectedBrandSlugs) {
                $query->whereIn('slug', $selectedBrandSlugs)->where('is_visible', true);
            });
        }
        if ($availability === 'in_stock') {
            $optionsQueryContextBase->where('quantity', '>', 0);
        } elseif ($availability === 'out_of_stock') {
            $optionsQueryContextBase->where(function ($query) {
                $query->where('quantity', '<=', 0)->orWhereNull('quantity');
            });
        }
        if ($isNewRequest) {
            $optionsQueryContextBase->where('is_new', true);
        }

        foreach ($activeSpecificFiltersConfig as $filterKey => $config) {
            $dbColumn = $config['db_column'] ?? null;
            if (!$dbColumn) {
                Log::warning("Для специфического фильтра '{$filterKey}' не указан 'db_column'.");
                continue;
            }
            $filterType = $config['type'];

            $optionsQueryContextForThisFilter = clone $optionsQueryContextBase;

            foreach ($activeSpecificFiltersConfig as $otherFilterKey => $otherConfig) {
                if ($otherFilterKey === $filterKey) continue;

                $otherRequestValue = $request->query($otherFilterKey);
                if ($otherRequestValue !== null && $otherRequestValue !== '') {
                    $otherDbColumn = $otherConfig['db_column'] ?? null;
                    if (!$otherDbColumn) continue;

                    $otherCastToNumeric = $otherConfig['cast_to_numeric'] ?? false;
                    if ($otherConfig['type'] === 'checkbox' && is_array($otherRequestValue) && !empty($otherRequestValue)) {
                        $cleanValues = array_filter(array_map(fn($v) => $otherCastToNumeric ? (is_numeric($v) ? (float)$v : null) : (string)$v, $otherRequestValue), fn($v) => $v !== null);
                        if (!empty($cleanValues)) $optionsQueryContextForThisFilter->whereIn($otherDbColumn, $cleanValues);
                    } elseif (in_array($otherConfig['type'], ['select', 'single_checkbox'])) {
                        $cleanValue = $otherCastToNumeric ? (is_numeric($otherRequestValue) ? (float)$otherRequestValue : null) : (string)$otherRequestValue;
                        if ($cleanValue !== null) $optionsQueryContextForThisFilter->where($otherDbColumn, $cleanValue);
                    }
                }
            }

            $queryForOptions = $optionsQueryContextForThisFilter->whereNotNull($dbColumn)->distinct();

            if (isset($config['sort_numeric']) && $config['sort_numeric']) {
                if (config('database.default') === 'mysql') {
                    $queryForOptions->orderByRaw("CAST(REGEXP_REPLACE({$dbColumn}, '[^0-9.]+', '') AS DECIMAL(10,2)) ASC, {$dbColumn} ASC");
                } else {
                    $queryForOptions->orderBy($dbColumn);
                }
            } else {
                $queryForOptions->orderBy($dbColumn);
            }

            $options = $queryForOptions->pluck($dbColumn);

            if ($options->isEmpty()) {
                continue;
            }

            $formattedOptions = $options->mapWithKeys(function ($value) use ($config) {
                $label = (string) $value;
                if (isset($config['options_map']) && isset($config['options_map'][$label])) {
                    $label = $config['options_map'][$label];
                } else {
                    if (isset($config['value_prefix'])) $label = $config['value_prefix'] . $label;
                    if (isset($config['value_suffix'])) $label .= $config['value_suffix'];
                }
                return [(string)$value => $label];
            })->filter()->all();

            if (!empty($formattedOptions)) {
                $availableSpecificFiltersData[$filterKey] = [
                    'label' => $config['label'],
                    'type' => $filterType,
                    'options' => $formattedOptions,
                    'request_key' => $filterKey
                ];
            }
            
            $requestValue = $request->query($filterKey);
            if ($requestValue !== null && $requestValue !== '') {
                $castToNumeric = $config['cast_to_numeric'] ?? false;
                if ($filterType === 'checkbox' && is_array($requestValue) && !empty($requestValue)) {
                    $cleanValues = array_filter(array_map(fn($v) => $castToNumeric ? (is_numeric($v) ? (float)$v : null) : (string)$v, $requestValue), fn($v) => $v !== null);
                    if (!empty($cleanValues)) $productsQuery->whereIn($dbColumn, $cleanValues);
                } elseif (in_array($filterType, ['select', 'single_checkbox'])) {
                    $cleanValue = $castToNumeric ? (is_numeric($requestValue) ? (float)$requestValue : null) : (string)$requestValue;
                    if ($cleanValue !== null) $productsQuery->where($dbColumn, $cleanValue);
                }
            }
        }

        $finalPriceRangeQuery = clone $productsQuery; 
        $overallMinPrice = floor($finalPriceRangeQuery->min('price') ?? 0);
        $overallMaxPrice = ceil($finalPriceRangeQuery->max('price') ?? 0);

        if ($overallMinPrice == $overallMaxPrice && $overallMaxPrice > 0) {
            $overallMinPrice = max(0, floor($overallMinPrice * 0.9)); 
            $overallMaxPrice = ceil($overallMaxPrice * 1.1);
        } elseif ($overallMinPrice >= $overallMaxPrice) { 
            if ($overallMaxPrice > 0) {
                $overallMinPrice = max(0, floor($overallMaxPrice * 0.9));
            } else { 
                $overallMinPrice = 0;
                $overallMaxPrice = 1000; 
            }
        }
        if ($overallMinPrice > $overallMaxPrice) $overallMinPrice = $overallMaxPrice;
        if ($minPriceRequest !== null && is_numeric($minPriceRequest)) {
            $productsQuery->where('price', '>=', (float)$minPriceRequest);
        }
        if ($maxPriceRequest !== null && is_numeric($maxPriceRequest)) {
            $productsQuery->where('price', '<=', (float)$maxPriceRequest);
        }

        // Сортировка
        switch ($sortBy) {
            case 'name_asc':
                $productsQuery->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $productsQuery->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'created_at_asc':
                $productsQuery->orderBy('created_at', 'asc');
                break;
            case 'created_at_desc':
            default:
                $productsQuery->orderBy('created_at', 'desc');
                break;
        }

        $products = $productsQuery->with(['category', 'brand']) 
            ->paginate(12) 
            ->appends($request->query()); 

        $sortOptions = [
            'created_at_desc' => 'Сначала новые',
            'created_at_asc' => 'Сначала старые',
            'price_asc' => 'Сначала дешевые',
            'price_desc' => 'Сначала дорогие',
            'name_asc' => 'Название (А → Я)',
            'name_desc' => 'Название (Я → А)',
        ];

        $brandsForFilterQuery = Product::query()->where('is_visible', true)->whereNotNull('brand_id');
        if (!empty($categoryIdsToFilter)) {
            $brandsForFilterQuery->whereIn('category_id', $categoryIdsToFilter);
        }

        foreach ($activeSpecificFiltersConfig as $filterKey => $config) {
            $requestValue = $request->query($filterKey);
            $dbColumn = $config['db_column'] ?? null;
            if ($dbColumn && $requestValue !== null && $requestValue !== '') {
                $castToNumeric = $config['cast_to_numeric'] ?? false;
                if ($config['type'] === 'checkbox' && is_array($requestValue) && !empty($requestValue)) {
                    $cleanValues = array_filter(array_map(fn($v) => $castToNumeric ? (is_numeric($v) ? (float)$v : null) : (string)$v, $requestValue), fn($v) => $v !== null);
                    if (!empty($cleanValues)) $brandsForFilterQuery->whereIn($dbColumn, $cleanValues);
                } elseif (in_array($config['type'], ['select', 'single_checkbox'])) {
                    $cleanValue = $castToNumeric ? (is_numeric($requestValue) ? (float)$requestValue : null) : (string)$requestValue;
                    if ($cleanValue !== null) $brandsForFilterQuery->where($dbColumn, $cleanValue);
                }
            }
        }
        $availableBrandIds = $brandsForFilterQuery->distinct()->pluck('brand_id');
        $availableBrands = Brand::whereIn('id', $availableBrandIds)->where('is_visible', true)->orderBy('name')->get();


        $currentMinPrice = $minPriceRequest !== null && is_numeric($minPriceRequest) ? (float)$minPriceRequest : $overallMinPrice;
        $currentMaxPrice = $maxPriceRequest !== null && is_numeric($maxPriceRequest) ? (float)$maxPriceRequest : $overallMaxPrice;

        return view('catalog.index', [
            'products' => $products,
            'categories' => $sidebarMenuCategories,
            'selectedCategorySlug' => $selectedCategorySlug,
            'selectedCategory' => $selectedCategory,
            'sortBy' => $sortBy,
            'sortOptions' => $sortOptions,
            'availableBrands' => $availableBrands,
            'selectedBrandSlugs' => $selectedBrandSlugs,
            'overallMinPrice' => $overallMinPrice,
            'overallMaxPrice' => $overallMaxPrice,
            'currentMinPrice' => $currentMinPrice,
            'currentMaxPrice' => $currentMaxPrice,
            'availability' => $availability,
            'request' => $request,
            'isNewRequest' => $isNewRequest, 

            'availableSpecificFiltersData' => $availableSpecificFiltersData,
            'activeSpecificFiltersConfig' => $activeSpecificFiltersConfig, 
        ]);
    }

    private function getSpecificFiltersConfigForCategory(?string $categorySlug): array
    {
        $config = [];

        if ($categorySlug === 'laptops-notebooks' || $categorySlug === 'laptops') { 
            $config['screen_size'] = [
                'label' => 'Диагональ ноутбука',
                'db_column' => 'screen_size', 
                'type' => 'checkbox',
                'value_suffix' => '"',
                'sort_numeric' => true,
                'cast_to_numeric' => true,
            ];
            $config['resolution'] = [
                'label' => 'Разрешение',
                'db_column' => 'resolution', 
                'type' => 'checkbox',
            ];
            $config['matrix_type'] = [
                'label' => 'Тип матрицы',
                'db_column' => 'matrix_type', 
                'type' => 'checkbox',
            ];
            $config['ram_size'] = [
                'label' => 'Объем ОЗУ',
                'db_column' => 'ram_size', 
                'type' => 'select', 
                'value_suffix' => ' ГБ',
                'sort_numeric' => true,
                'cast_to_numeric' => true,
            ];
            $config['cpu_type'] = [
                'label' => 'Процессор',
                'db_column' => 'cpu_type', 
                'type' => 'select',
            ];
            $config['ssd_volume'] = [
                'label' => 'Объем SSD',
                'db_column' => 'ssd_volume', 
                'type' => 'select',
            ];
            $config['os_type'] = [
                'label' => 'Операционная система',
                'db_column' => 'os_type', 
                'type' => 'select',
            ];
        } elseif (in_array($categorySlug, ['monitory-kt', 'monitory-dlya-pk', 'monitory'])) { 
            $config['screen_size'] = [
                'label' => 'Диагональ монитора',
                'db_column' => 'screen_size',
                'type' => 'checkbox',
                'value_suffix' => '"',
                'sort_numeric' => true,
                'cast_to_numeric' => true,
            ];

        } elseif (in_array($categorySlug, ['aksessuary', 'telefony', 'smartfony'])) {
            $config['os_type'] = [
                'label' => 'ОС смартфона',
                'db_column' => 'os_type', 
                'type' => 'select',
            ];
            $config['mobile_ram_size'] = [ 
                'label' => 'ОЗУ смартфона',
                'db_column' => 'ram_size', 
                'type' => 'select',
                'value_suffix' => ' ГБ',
                'sort_numeric' => true,
                'cast_to_numeric' => true,
            ];
            $config['internal_memory'] = [
                'label' => 'Встроенная память',
                'db_column' => 'ssd_volume',
                'type' => 'select',
                'value_suffix' => ' ГБ',
                'sort_numeric' => true,
                'cast_to_numeric' => true,
            ];
        }

        return $config;
    }

    public function show(string $slug): View
    {
        $product = Product::where('slug', $slug)
            ->where('is_visible', true)
            ->with(['category', 'brand'])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_visible', true)
            ->with('brand')
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('catalog.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
