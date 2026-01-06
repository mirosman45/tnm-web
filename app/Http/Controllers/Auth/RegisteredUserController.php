<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);

        // Create the user with OTP and not verified
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',                      // default role
            'blocked' => false,                    // default unblocked
            'otp' => $otp,                         // store OTP
            'otp_expires_at' => now()->addMinutes(10), // OTP valid 10 min
            'is_verified' => false,                // not verified yet
        ]);

        // Send OTP email
        try {
            Mail::to($user->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            // If email sending fails, delete user to prevent unverified users
            $user->delete();
            return back()->with('error', 'Failed to send OTP. Please try again.');
        }

        // Redirect to OTP verification page
        return redirect()->route('otp.form')->with('email', $user->email)
                                            ->with('success', 'OTP sent to your email. Please verify.');
    }
}
