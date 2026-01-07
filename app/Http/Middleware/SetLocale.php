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
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $allowed = ['en', 'ps', 'fa'];

        if ($locale = Session::get('locale')) {
            App::setLocale(in_array($locale, $allowed) ? $locale : config('app.locale'));
        }

        return $next($request);
    }
}