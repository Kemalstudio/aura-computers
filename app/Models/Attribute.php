<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'options',
        'unit',
        'description',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    // Relationship to Categories via the pivot table
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_attribute')
            ->withPivot('is_required', 'is_filterable', 'is_variant_defining', 'sort_order')
            ->withTimestamps();
    }

    // Relationship to ProductAttributeValue (all values for this attribute across products)
    public function productValues(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    // NO attributeDefinition() relationship here.
}
