<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

// Подключаем все необходимые контроллеры
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StoreReviewController;
use App\Http\Controllers\FavoritesController; 
use App\Http\Controllers\CompareController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [ProductController::class, 'index'])->name('catalog.index');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.show');

Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

Route::post('/reviews/{product}', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::post('/store-reviews', [StoreReviewController::class, 'store'])->name('store-reviews.store');

Route::get('locale/{locale}', function (Request $request, string $locale) {
    if (in_array($locale, config('app.available_locales', ['en', 'ru', 'tm']))) {
        Session::put('locale', $locale);
    }
    return redirect()->back()->withInput($request->except(['_token', '_method']));
})->name('locale.switch');

Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites.index');

    Route::post('/favorites/toggle/{product}', [FavoritesController::class, 'toggle'])->name('favorites.toggle');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('compare')->name('compare.')->group(function () {
    Route::get('/', [CompareController::class, 'index'])->name('index'); 
    Route::post('/toggle/{product}', [CompareController::class, 'toggle'])->name('toggle'); 
    Route::post('/clear', [CompareController::class, 'clear'])->name('clear');
});

require __DIR__ . '/auth.php'; 