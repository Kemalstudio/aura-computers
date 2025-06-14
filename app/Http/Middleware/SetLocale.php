<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App; // Make sure this line is present

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // If the session has a 'locale' value...
        if (session()->has('locale')) {
            // ...tell the entire application to use that locale.
            App::setLocale(session('locale'));
        }

        return $next($request);
    }
}