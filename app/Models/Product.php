<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\ProductAttributeValue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'short_description', 'description', 'long_description',
        'price', 'sale_price', 'quantity', 'sku', 'barcode',
        'is_visible', 'is_new', 'is_featured', 'on_sale',
        'thumbnail_url', 'images', 'category_id', 'brand_id',
        'meta_title', 'meta_description', 'meta_keywords',
    ];

    protected $casts = [
        'images' => 'json',
        'is_visible' => 'boolean', 'is_new' => 'boolean', 'is_featured' => 'boolean', 'on_sale' => 'boolean',
        'price' => 'decimal:2', 'sale_price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class); // Ensure Review model and table exist
    }

    public function attributeValues(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function MappedAttributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute_values')
            ->withPivot([
                'id as pav_id', 'text_value', 'integer_value', 'decimal_value',
                'boolean_value', 'date_value', 'datetime_value'
            ])
            ->using(ProductAttributeValue::class)
            ->withTimestamps();
    }

    public function getProductAttributeValueBySlug(string $attributeSlug)
    {
        if (!$this->relationLoaded('MappedAttributes')) {
            $this->load('MappedAttributes');
        }
        $attributeModel = $this->MappedAttributes->firstWhere('slug', $attributeSlug);
        if (!$attributeModel || !is_object($attributeModel)) {
            Log::debug("Product::getProductAttributeValueBySlug - Product ID {$this->id}: Attribute '{$attributeSlug}' not found or not object.", ['found_attribute' => $attributeModel]);
            return null;
        }
        if ($attributeModel->pivot) {
            $pivotInstance = $attributeModel->pivot;
            if ($pivotInstance instanceof ProductAttributeValue) {
                $pivotInstance->setRelation('attributeDefinition', $attributeModel);
                return $pivotInstance->value;
            }
        }
        return null;
    }

    public function getDisplayableAttributes(): Collection
    {
        $displayable = [];
        if (!$this->relationLoaded('MappedAttributes')) $this->load('MappedAttributes');
        if ($this->category && !$this->category->relationLoaded('attributes')) {
            $this->category->loadMissing('attributes');
        } elseif (!$this->relationLoaded('category.attributes') && $this->category_id) {
            $this->loadMissing('category.attributes');
        }

        $categoryAttributeSortOrders = [];
        if ($this->category && $this->category->relationLoaded('attributes')) {
            foreach ($this->category->attributes as $catAttr) {
                if (!($catAttr instanceof Attribute)) {
                    Log::error("Product::getDisplayableAttributes - Product ID {$this->id}: \$catAttr in category loop is not Attribute object.", ['type' => gettype($catAttr), 'value' => $catAttr]);
                    continue;
                }
                $categoryAttributeSortOrders[$catAttr->id] = $catAttr->pivot->sort_order ?? 999;
            }
        }

        foreach ($this->MappedAttributes as $attributeModel) {
            if (!($attributeModel instanceof Attribute)) {
                Log::error("Product::getDisplayableAttributes - Product ID {$this->id}: \$attributeModel in MappedAttributes loop is not Attribute object.", ['type' => gettype($attributeModel), 'value' => $attributeModel]);
                continue;
            }
            $pivotInstance = $attributeModel->pivot;
            if ($pivotInstance instanceof ProductAttributeValue) {
                $pivotInstance->setRelation('attributeDefinition', $attributeModel);
                $value = $pivotInstance->value;
                if ($value !== null && (is_string($value) ? trim($value) !== '' : true)) {
                    $displayable[] = (object) [
                        'id' => $attributeModel->id, 'name' => $attributeModel->name, 'slug' => $attributeModel->slug,
                        'value' => $value, 'unit' => $attributeModel->unit, 'type' => $attributeModel->type,
                        'sort_order' => $categoryAttributeSortOrders[$attributeModel->id] ?? 999,
                    ];
                }
            } elseif($pivotInstance) {
                Log::warning("Product::getDisplayableAttributes - Product ID {$this->id}: Pivot for '{$attributeModel->name}' is not ProductAttributeValue. Type: " . get_class($pivotInstance));
            }
        }
        return collect($displayable)->sortBy('sort_order');
    }
}
