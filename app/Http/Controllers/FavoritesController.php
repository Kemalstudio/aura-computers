<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View; // Правильный импорт для типа возвращаемого значения
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Exception;

class FavoritesController extends Controller
{
    /**
     * Отображает страницу с избранными товарами пользователя.
     */
    public function index(): View
    {
        // === ИСПРАВЛЕНИЕ ЗДЕСЬ ===
        // Мы явно указываем, что сортировать нужно по полю `created_at` из таблицы `favorite_product`.
        $products = Auth::user()
            ->favorites()
            ->orderBy('favorite_product.created_at', 'desc') // Правильная сортировка по дате добавления
            ->paginate(12);

        return view('favorites.index', compact('products'));
    }

    /**
     * Добавляет или удаляет товар из избранного (для AJAX запросов).
     */
    public function toggle(Product $product): JsonResponse
    {
        try {
            $user = Auth::user();
            $user->favorites()->toggle($product->id);

            return response()->json([
                'success' => true,
                'count'   => $user->favorites()->count(),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка сервера. Не удалось обновить избранное.'
            ], 500);
        }
    }
}