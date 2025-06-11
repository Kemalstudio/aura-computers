<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review as ProductReview; 
use App\Models\StoreReview;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        $newProducts = Product::latest()
            ->take(8)
            ->get();

        $productReviews = ProductReview::where('is_approved', true)
            ->with('product') 
            ->latest()
            ->take(6)
            ->get();

        $storeReviews = StoreReview::where('is_approved', true)
            ->latest()
            ->take(8)
            ->get();

        return view('home', [
            'featuredProducts' => $featuredProducts,
            'newProducts'      => $newProducts,
            'productReviews'   => $productReviews,
            'storeReviews'     => $storeReviews,
        ]);
    }
}