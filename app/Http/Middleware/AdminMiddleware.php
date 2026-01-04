<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // 1️⃣ Check if user is logged in
        if (!Auth::check()) {
            return redirect('/admin/login')->with('error', 'Please log in to access admin area.');
        }

        $user = Auth::user();

        // 2️⃣ Check if user role is admin
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized'); // You can also redirect to home page
        }

        // 3️⃣ Optional: check if user is blocked
        if ($user->blocked) {
            Auth::logout();
            return redirect('/')->with('error', 'Your account is blocked.');
        }

        // 4️⃣ Pass the request to the next middleware/controller
        return $next($request);
    }
}
