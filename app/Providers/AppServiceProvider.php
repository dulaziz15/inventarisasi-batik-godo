<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            $appUrl = rtrim((string) config('app.url'), '/');

            // Shared hosting users often set APP_URL with /public.
            // Normalize it so generated URLs always target domain root.
            if (str_ends_with($appUrl, '/public')) {
                $appUrl = substr($appUrl, 0, -7);
            }

            if ($appUrl !== '') {
                URL::forceRootUrl($appUrl);
            }

            if (str_starts_with($appUrl, 'https://')) {
                URL::forceScheme('https');
            }
        }
    }
}
