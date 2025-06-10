<?php

namespace App\Http\Controllers;

use App\Models\StoreReview;

class WelcomeController extends Controller
{
    public function index()
    {\
        $storeReviews = StoreReview::where('is_approved', true)
                                   ->latest() 
                                   ->take(10) 
                                   ->get();

        return view('welcome', [
            'storeReviews' => $storeReviews,
        ]);
    }
}