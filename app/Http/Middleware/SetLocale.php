<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            if (in_array($locale, config('app.available_locales', ['en', 'ru', 'tm']))) {
                App::setLocale($locale);
            } else {
                App::setLocale(config('app.fallback_locale', 'ru'));
            }
        } else {
            App::setLocale(config('app.fallback_locale', 'ru'));
        }

        return $next($request);
    }
}