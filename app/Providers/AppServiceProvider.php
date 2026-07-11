<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Memaksa Laravel menggunakan HTTPS jika diakses via Ngrok (di environment production/lokal yang di-forward)
        if (str_contains(request()->url(), 'ngrok-free.dev')) {
            URL::forceScheme('https');
        }
    }
}
