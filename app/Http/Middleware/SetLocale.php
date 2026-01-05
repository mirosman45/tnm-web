<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * This middleware runs after StartSession middleware,
     * so the session is available.
     */
    public function handle(Request $request, Closure $next)
    {
        // Allowed locales
        $allowedLocales = ['en', 'ps', 'fa'];

        // Set locale from session if valid
        if (Session::has('locale') && in_array(Session::get('locale'), $allowedLocales)) {
            App::setLocale(Session::get('locale'));
        } else {
            // Fallback to default locale
            App::setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
