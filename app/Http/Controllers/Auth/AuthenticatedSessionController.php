<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate user credentials
        $request->authenticate();

        // Regenerate session to prevent session fixation
        $request->session()->regenerate();

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // Safety fallback
        if (!$user) {
            Auth::logout();
            return redirect()->route('login');
        }

        // Blocked users check
        if ($user->blocked) {
            Auth::logout();
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Your account has been blocked by the administrator.',
                ]);
        }

        // Admin users → redirect to admin dashboard
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Normal users → redirect to home page
        return redirect()->route('home');
    }

    /**
     * Handle logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        // Invalidate session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
