<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    /**
     * Show OTP verification form
     */
    public function showForm()
    {
        return view('otp'); // resources/views/otp.blade.php
    }

    /**
     * Verify OTP and log in the user
     */
    public function verify(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        // Find user by email + OTP + expiry
        $user = User::where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->where('otp_expires_at', '>=', now())
                    ->first();

        // If no user found → invalid OTP
        if (!$user) {
            return back()->with('error', 'Invalid OTP or expired.');
        }

        // Check if user is blocked
        if ($user->is_blocked) {
            return back()->with('error', 'Your account is blocked.');
        }

        // Check if user is already verified (optional)
        if ($user->is_verified) {
            return redirect()->route('home')->with('success', 'Your email is already verified!');
        }

        // Mark user as verified
        $user->is_verified = true;
        $user->otp = null; // clear OTP
        $user->otp_expires_at = null;
        $user->save();

        // Safely log in the user using web guard
        Auth::guard('web')->login($user);

        // Redirect to home
        return redirect()->route('home')->with('success', 'Email verified successfully!');
    }
}
