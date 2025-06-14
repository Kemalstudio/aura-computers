<?php

namespace App\Http\Controllers;

class LanguageController extends Controller
{
    public function switch(string $locale)
    {
        if (in_array($locale, config('app.available_locales', ['en', 'ru', 'tm']))) {
            session()->put('locale', $locale);
        }
        return redirect()->back();
    }
}