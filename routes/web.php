<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\StoreReviewController;
use App\Http\Controllers\LocaleController; // Рекомендуется для логики языка

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Маршруты сгруппированы для лучшей читаемости и поддержки.
*/

// --- 1. ПУБЛИЧНЫЕ МАРШРУТЫ (Доступны всем) ---

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [ProductController::class, 'index'])->name('catalog.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('product.show');

// Маршрут для переключения языка
// routes/web.php

Route::get('locale/{locale}', function ($locale) {
    // Check if the selected locale is in our list of available locales
    if (in_array($locale, config('app.available_locales', ['en', 'ru', 'tm']))) {
        // If it is, put it in the session
        session()->put('locale', $locale);
    }
    // Redirect the user back to the previous page
    return redirect()->back();
})->name('locale.switch');

// API-поиск для модального окна отзывов
Route::get('/api/products/search', [ProductController::class, 'search'])->name('api.products.search');

// Публичный маршрут для отзывов о магазине
Route::post('/store-reviews', [StoreReviewController::class, 'store'])->name('store-reviews.store');


// --- 2. МАРШРУТЫ, ТРЕБУЮЩИЕ АУТЕНТИФИКАЦИИ ---

Route::middleware(['auth'])->group(function () {
    // Профиль
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Корзина
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

    // Избранное
    Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{product}', [FavoritesController::class, 'toggle'])->name('favorites.toggle');

    // Сравнение
    Route::get('/compare', [CompareController::class, 'index'])->name('compare.index');
    Route::post('/compare/toggle/{product}', [CompareController::class, 'toggle'])->name('compare.toggle');
    Route::post('/compare/clear', [CompareController::class, 'clear'])->name('compare.clear');

    // Отзывы о товарах (единый правильный маршрут)
    Route::post('/products/{product}/reviews', [ProductReviewController::class, 'store'])->name('products.reviews.store');
});


// --- 3. СИСТЕМНЫЕ МАРШРУТЫ ---

require __DIR__ . '/auth.php';
