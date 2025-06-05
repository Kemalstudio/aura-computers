<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo_path',
        'is_visible',
    ];

    // Отношение: бренд может иметь много товаров (определим позже)
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}