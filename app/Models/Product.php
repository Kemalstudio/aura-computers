<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'description', 
        'long_description', 
        'short_description', 
        'price',
        'sale_price', 
        'quantity', 
        'thumbnail_url',
        'images', 
        'is_visible',
        'is_new',
        'is_featured',
        'on_sale', 
        'barcode',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'screen_size',     // Например, 15.6 (число)
        'resolution',      // Например, '1920x1080' (строка)
        'matrix_type',     // Например, 'IPS' (строка)
        'refresh_rate',    // Например, 144 (число)
        'response_time',   // Например, 1 (число)
        'ram_size',        // Например, 16 (число, ГБ подразумевается)
        'cpu_type',        // Например, 'Intel Core i7' (строка)
        'ssd_volume',      // Например, 512 (число, ГБ подразумевается)
        'gpu_type',        // Например, 'NVIDIA RTX 3060' (строка)
        'os_type',         // Например, 'Windows 11' или 'Android' (строка)
        'appliance_type',
        'chair_material',
        'chair_mechanism',
        'table_adjustment',
        'network_device_type',
        'security_system_type',
        'specifications', // JSON для прочих характеристик
        // Поля ниже были в вашем $fillable, но не ясно, нужны ли они, если есть более конкретные:
        // 'screen_resolution', // Есть 'resolution'
        // 'screen_matrix_type',// Есть 'matrix_type'
        // 'laptop_os',         // Есть 'os_type'
        // 'laptop_purpose',
        // 'storage_type',      // Можно определить по наличию ssd_volume/hdd_volume
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'is_new' => 'boolean',
        'is_featured' => 'boolean',
        'on_sale' => 'boolean',
        'images' => 'array',
        'specifications' => 'array',
        'price' => 'float',
        'sale_price' => 'float', // Было 'old_price', но 'sale_price' логичнее для цены со скидкой
        'quantity' => 'integer', // Было 'stock'
        'refresh_rate' => 'integer',
        'response_time' => 'integer',
        'screen_size' => 'float', // Если храните как число
        'ram_size' => 'integer',  // Если храните как число
        'ssd_volume' => 'integer', // Если храните как число
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
        return $this->hasMany(Review::class)->latest();
    }

    public function isInStock(): bool
    {
        return $this->quantity > 0; // Используем 'quantity'
    }

    // Аксессор для получения цены с учетом скидки (если нужно)
    public function getCurrentPriceAttribute(): float
    {
        if ($this->on_sale && $this->sale_price !== null && $this->sale_price < $this->price) {
            return $this->sale_price;
        }
        return $this->price;
    }

    // Если у вас было поле old_price для отображения старой цены, когда товар on_sale
    // public function getDisplayOldPriceAttribute(): ?float
    // {
    //     if ($this->on_sale && $this->sale_price !== null && $this->sale_price < $this->price) {
    //         return $this->price;
    //     }
    //     return null;
    // }
}
