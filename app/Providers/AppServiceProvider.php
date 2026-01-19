<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Request;

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
        // Force HTTPS for local environment (ngrok requires HTTPS)
        if (app()->environment('local')) {
            URL::forceScheme('https');
        }

        // Trust all proxies (ngrok acts as a reverse proxy)
        // Instead of HEADER_X_FORWARDED_ALL, use the integer 0b1111 (15)
        Request::setTrustedProxies(
            ['0.0.0.0/0'], // Trust all IPs
            Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PROTO | Request::HEADER_X_FORWARDED_PORT
        );
    }
}
