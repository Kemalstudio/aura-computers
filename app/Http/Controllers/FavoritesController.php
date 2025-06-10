<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    /**
     * Показывает страницу с избранными товарами пользователя.
     */
    public function index()
    {
        // Получаем залогиненного пользователя и его избранные товары
        $favoriteProducts = Auth::user()->favorites()->latest()->paginate(12);

        // Возвращаем красивый шаблон и передаем в него товары
        return view('favorites.index', [
            'products' => $favoriteProducts
        ]);
    }

    /**
     * Добавляет или удаляет товар из избранного (для JavaScript).
     * Возвращает JSON-ответ.
     */
    public function toggle(Product $product): JsonResponse
    {
        // toggle() - волшебный метод, который сам добавляет/удаляет связь
        $result = Auth::user()->favorites()->toggle($product->id);

        // Проверяем, был ли товар добавлен или удален
        $isFavorite = !empty($result['attached']);

        // Считаем новое общее количество товаров в избранном
        $newCount = Auth::user()->favorites()->count();

        // Возвращаем ответ для JavaScript
        return response()->json([
            'success'     => true,
            'is_favorite' => $isFavorite,
            'new_count'   => $newCount,
        ]);
    }
}
