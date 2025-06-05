<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Category extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'a',
        'slug',
        'icon_url',        
        'description',
        'parent_id',
        'is_visible',
        'sort_order',       
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_visible' => 'boolean',
        'parent_id' => 'integer',
        'sort_order' => 'integer',
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->where('is_visible', true) 
            ->orderBy('sort_order', 'asc') 
            ->orderBy('name', 'asc');      
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return string|null
     */
    public function getFullIconUrlAttribute(): ?string
    {
        if ($this->icon_url) {
            if (filter_var($this->icon_url, FILTER_VALIDATE_URL)) {
                return $this->icon_url;
            }
            return asset($this->icon_url);
        }
        return null;
    }

    /**
     * @return array
     */
    public function getSelfAndVisibleDescendantsIds(): array
    {
        $ids = [$this->id];

        foreach ($this->children as $child) { 
            $ids = array_merge($ids, $child->getSelfAndVisibleDescendantsIds());
        }
        return array_unique($ids);
    }

    /**
     * @return Collection
     */
    public function getSelfAndVisibleDescendants(): Collection
    {
        $categories = collect([$this]);

        foreach ($this->children as $child) { 
            $categories = $categories->merge($child->getSelfAndVisibleDescendants());
        }
        return $categories;
    }


    /**
     * @param \Illuminate\Database\Eloquent\Builder 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * @param Category 
     * @return bool
     */
    public function isAncestorOf(Category $possibleDescendant): bool
    {
        $parent = $possibleDescendant->parent; 
        while ($parent) {
            if ($parent->id === $this->id) {
                return true;
            }
            $parent = $parent->parent; 
        }
        return false;
    }

    /**
     * @return Collection
     */
    public function getBreadcrumbs(): Collection
    {
        $breadcrumbs = collect();
        $category = $this; 

        while ($category) {
            $breadcrumbs->prepend($category);
            $category = $category->parent;    
        }

        return $breadcrumbs;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder 
     * @param int
     * @return void
     */
    public function scopeWithVisibleChildrenRecursive($query, $depth = 0)
    {
        $query->with(['children' => function ($query) use ($depth) {
            if ($depth > 1 || $depth === 0) { 
                $newDepth = ($depth === 0) ? 0 : $depth - 1;
                $query->withVisibleChildrenRecursive($newDepth);
            }
        }]);
    }
}