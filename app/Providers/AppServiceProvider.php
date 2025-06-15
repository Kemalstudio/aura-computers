<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $currentLocale = App::getLocale();
            $locales = [
                'ru' => ['name' => 'Русский', 'flag' => 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/ru.svg'],
                'en' => ['name' => 'English', 'flag' => 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/gb.svg'],
                'tm' => ['name' => 'Türkmençe', 'flag' => 'https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/tm.svg'],
            ];
            $view->with('currentLocale', $currentLocale)->with('locales', $locales);
        });
    }
}