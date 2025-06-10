<?php

namespace App\Models;

use App\Models\Product; // <-- Важно: импортируем модель Product
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Атрибуты, которые можно массово назначать.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Атрибуты, которые должны быть скрыты при сериализации.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- НАЧАЛО ВОССТАНОВЛЕННОГО КОДА ---

    /**
     * Определяет отношение "многие-ко-многим" с моделью Product.
     * Этот метод позволяет получать все товары, которые пользователь добавил в "Избранное".
     */
    public function favorites()
    {
        // Указываем, что User связан с Product через таблицу 'favorite_product'
        return $this->belongsToMany(Product::class, 'favorite_product');
    }

    // --- КОНЕЦ ВОССТАНОВЛЕННОГО КОДА ---
}