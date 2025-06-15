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
use App\Http\Controllers\LocaleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. ПУБЛИЧНЫЕ МАРШРУТЫ ---

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [ProductController::class, 'index'])->name('catalog.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('locale/{locale}', function ($locale) {
    if (in_array($locale, config('app.available_locales', ['en', 'ru', 'tm']))) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('locale.switch');

Route::get('/api/products/search', [ProductController::class, 'search'])->name('api.products.search');
Route::post('/store-reviews', [StoreReviewController::class, 'store'])->name('store-reviews.store');

// --- 2. МАРШРУТЫ, ТРЕБУЮЩИЕ АУТЕНТИФИКАЦИИ ---

Route::middleware(['auth'])->group(function () {
    // Профиль
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Корзина (API-ориентированные маршруты)
    Route::prefix('cart')->name('cart.')->group(function () {
        // ИСПРАВЛЕНО ЗДЕСЬ: getCartContent -> index
        Route::get('/', [CartController::class, 'index'])->name('index'); 
        Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
        Route::post('/update/{rowId}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{rowId}', [CartController::class, 'remove'])->name('remove');
    });

    // Избранное
    Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{product}', [FavoritesController::class, 'toggle'])->name('favorites.toggle');

    // Сравнение
    Route::get('/compare', [CompareController::class, 'index'])->name('compare.index');
    Route::post('/compare/toggle/{product}', [CompareController::class, 'toggle'])->name('compare.toggle');
    Route::post('/compare/clear', [CompareController::class, 'clear'])->name('compare.clear');

    // Отзывы о товарах
    Route::post('/products/{product}/reviews', [ProductReviewController::class, 'store'])->name('products.reviews.store');
});

// --- 3. СИСТЕМНЫЕ МАРШРУТЫ ---

require __DIR__ . '/auth.php';