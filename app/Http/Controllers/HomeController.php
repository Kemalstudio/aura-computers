<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\StoreReview;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Отображает главную страницу с категориями товаров и отзывами.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Получаем последние одобренные отзывы о товарах
        $productReviews = ProductReview::where('is_approved', true)
            ->with('product:id,name,thumbnail_url') // Загружаем только необходимые поля для производительности
            ->latest()
            ->take(10)
            ->get();

        // Получаем последние одобренные отзывы о магазине
        $storeReviews = StoreReview::where('is_approved', true)
            ->latest()
            ->take(10)
            ->get();

        // --- НОВАЯ ЛОГИКА ДЛЯ ГРУППИРОВКИ ТОВАРОВ ПО КАТЕГОРИЯМ ---

        // 1. Получаем все видимые родительские категории (у которых нет родителя),
        //    сортируем их и сразу подгружаем их дочерние категории.
        $parentCategories = Category::whereNull('parent_id')
            ->where('is_visible', true)
            ->orderBy('sort_order', 'asc')
            ->with('children')
            ->get();

        $categoriesWithProducts = [];

        // 2. Для каждой родительской категории, находим её товары
        foreach ($parentCategories as $parent) {
            // Собираем ID всех дочерних категорий, принадлежащих этой родительской
            $childCategoryIds = $parent->children->pluck('id');

            // Если у родительской категории нет дочерних, пропускаем ее, чтобы не делать лишний запрос
            if ($childCategoryIds->isEmpty()) {
                continue;
            }

            // 3. Выбираем до 8 случайных видимых товаров из этих дочерних категорий
            $products = Product::where('is_visible', true)
                ->whereIn('category_id', $childCategoryIds)
                ->with(['brand', 'category']) // Подгружаем связи, необходимые для карточки товара
                ->inRandomOrder() // Чтобы при каждой загрузке страницы товары были разными
                ->take(8)
                ->get();

            // 4. Добавляем в массив для вывода, только если для этой категории нашлись товары
            if ($products->isNotEmpty()) {
                $categoriesWithProducts[] = [
                    'category' => $parent,
                    'products' => $products,
                ];
            }
        }
        return view('home', [
            'productReviews' => $productReviews,
            'storeReviews' => $storeReviews,
            'categoriesWithProducts' => $categoriesWithProducts,
        ]);
    }
}