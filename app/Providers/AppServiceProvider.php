<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // пусто
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            $currentLocale = app()->getLocale();

            $locales = [
                'tm' => ['name' => 'Türkmençe', 'flag' => 'https://flagcdn.com/w20/tm.png'],
                'ru' => ['name' => 'Русский', 'flag' => 'https://flagcdn.com/w20/ru.png'],
                'en' => ['name' => 'English', 'flag' => 'https://flagcdn.com/w20/gb.png'],
            ];

            $view->with('currentLocale', $currentLocale)->with('locales', $locales);
        });
    }
}
