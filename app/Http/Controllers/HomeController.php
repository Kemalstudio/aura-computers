<?php

namespace App\Http\Controllers;

use App\Models\Product; // Подключаем модель Product
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Получим несколько последних или рекомендуемых товаров для главной
        $featuredProducts = Product::where('is_featured', true)
                                  ->where('is_visible', true)
                                  ->latest()
                                  ->take(8) // Например, 8 товаров
                                  ->get();

        $newProducts = Product::where('is_new', true)
                            ->where('is_visible', true)
                            ->latest()
                            ->take(8)
                            ->get();


        return view('home', [
            'featuredProducts' => $featuredProducts,
            'newProducts' => $newProducts,
        ]);
    }
}