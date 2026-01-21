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
            'otp' => 'nullable|digits:6', // OTP optional for admins
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        // Skip OTP verification for admins
        if ($user->role !== 'admin') {
            if (!$user->otp || $user->otp != $request->otp || $user->otp_expires_at < now()) {
                return back()->with('error', 'Invalid OTP or expired.');
            }

            // Mark user as verified
            $user->is_verified = true;
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();
        }

        // Check if user is blocked
        if ($user->is_blocked) {
            return back()->with('error', 'Your account is blocked.');
        }

        // Safely log in the user
        Auth::guard('web')->login($user);

        return redirect()->route('home')->with('success', 'Logged in successfully!');
    }
}
