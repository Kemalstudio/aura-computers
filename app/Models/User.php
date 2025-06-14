<?php

namespace App\Models;

// Подключаем необходимые классы
use App\Models\Product; // Модель Product для связи
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Важно для определения отношений

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Атрибуты, которые должны быть скрыты при сериализации.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Определяет отношение "многие-ко-многим" для избранных товаров.
     * Этот метод позволяет получать все товары, которые пользователь добавил в "Избранное".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favorites(): BelongsToMany
    {
        // Указываем, что User связан с Product через сводную таблицу 'favorite_product'
        return $this->belongsToMany(Product::class, 'favorite_product');
    }

    /**
     * +++ НОВЫЙ МЕТОД +++
     *
     * Определяет отношение "многие-ко-многим" для товаров в сравнении.
     * Этот метод позволяет получать все товары, которые пользователь добавил для сравнения.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function compares(): BelongsToMany
    {
        // Указываем, что User связан с Product через сводную таблицу 'compare_product'
        return $this->belongsToMany(Product::class, 'compare_product');
    }
}