<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review as ProductReview; // Используем псевдоним, чтобы было понятнее
use App\Models\StoreReview;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Отображает главную страницу сайта.
     */
    public function index()
    {
        // Загружаем 8 последних "рекомендуемых" товаров.
        $featuredProducts = Product::where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        // Загружаем 8 самых новых товаров в каталоге.
        $newProducts = Product::latest()
            ->take(8)
            ->get();

        // --- ИМЕННО ЭТА ЧАСТЬ ВЫЗЫВАЛА ОШИБКУ ---
        // Загружаем 6 последних ОДОБРЕННЫХ отзывов о товарах.
        // Запрос ищет колонку `is_approved` в таблице `reviews`.
        $productReviews = ProductReview::where('is_approved', true)
            ->with('product') // Загружаем информацию о продукте для каждого отзыва
            ->latest()
            ->take(6)
            ->get();
        // ------------------------------------------

        // Загружаем 8 последних ОДОБРЕННЫХ отзывов о магазине.
        $storeReviews = StoreReview::where('is_approved', true)
            ->latest()
            ->take(8)
            ->get();

        // Передаем все данные в представление 'welcome'
        return view('home', [
            'featuredProducts' => $featuredProducts,
            'newProducts'      => $newProducts,
            'productReviews'   => $productReviews,
            'storeReviews'     => $storeReviews,
        ]);
    }
}