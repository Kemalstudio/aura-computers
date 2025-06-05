<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Add this

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'is_visible',
    ];
    // In app/Models/Category.php
    public function getSelfAndVisibleDescendantsIds(): array
    {
        $ids = [$this->id];
        foreach ($this->children()->where('is_visible', true)->get() as $child) {
            $ids = array_merge($ids, $child->getSelfAndVisibleDescendantsIds());
        }
        return array_unique($ids);
    }
    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Attributes that are defined for this category.
     */
    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'category_attribute')
            ->withPivot('is_required', 'is_filterable', 'is_variant_defining', 'sort_order') // <<< These must match migration
            ->orderBy('pivot_sort_order')
            ->withTimestamps();
    }
}
