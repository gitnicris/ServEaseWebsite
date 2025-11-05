<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ForgotPasswordCodeController extends Controller
{
    // Step 1: Show email input form
    public function showEmailForm()
    {
        return view('auth.forgot-password');
    }

    // Step 2: Send verification code
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Rate limit: prevent multiple codes within 2 minutes
        if ($user->code_sent_at && Carbon::parse($user->code_sent_at)->diffInMinutes(now()) < 2) {
            return back()->with('error', 'You can request another code after 2 minutes.');
        }

        $code = rand(100000, 999999); // 6-digit code
        $user->update([
            'verification_code' => $code,
            'code_expires_at' => now()->addMinutes(10),
            'code_sent_at' => now(),
        ]);

        // Send email
        Mail::raw("Your ServEase verification code is: {$code}. It will expire in 10 minutes.", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('ServEase Password Reset Code');
        });

        session(['password_reset_email' => $user->email]);
        return redirect()->route('password.code.verify.form')->with('status', 'Verification code sent! Check your email.');
    }

    // Step 3: Show verify code form
    public function showVerifyForm()
    {
        return view('auth.verify-code');
    }

    // Step 4: Verify code
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $email = session('password_reset_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.code.request')->with('error', 'Session expired. Please try again.');
        }

        if ($user->verification_code != $request->code) {
            return back()->with('error', 'Invalid verification code.');
        }

        if (Carbon::parse($user->code_expires_at)->isPast()) {
            return back()->with('error', 'Code has expired. Please request a new one.');
        }

        session(['verified_email' => $email]);
        return redirect()->route('password.reset.form')->with('status', 'Code verified! You can now reset your password.');
    }

    // Step 5: Show reset password form
    public function showResetForm()
    {
        return view('auth.reset-password');
    }

    // Step 6: Reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email = session('verified_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.code.request')->with('error', 'Session expired. Please try again.');
        }

        $user->update([
            'password' => Hash::make($request->password),
            'verification_code' => null,
            'code_expires_at' => null,
            'code_sent_at' => null,
        ]);

        session()->forget(['verified_email', 'password_reset_email']);

        return redirect()->route('login')->with('status', 'Password has been reset successfully.');
    }
}
