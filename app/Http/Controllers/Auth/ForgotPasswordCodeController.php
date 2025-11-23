<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordResetCode;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordCodeController extends Controller
{
    /**
     * Step 1: Show email input form
     */
    public function showEmailForm()
    {
        return view('auth.forgot-password-code');
    }

    /**
     * Step 2: Send verification code
     */
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->email;

        // Check spam prevention
        $existing = PasswordResetCode::where('email', $email)->first();

        if ($existing && $existing->sent_at && Carbon::parse($existing->sent_at)->diffInMinutes(now()) < 2) {
            return back()->with('error', 'You can request another code after 2 minutes.');
        }

        // Generate a 6-digit code
        $code = rand(100000, 999999);

        // Store or update code record
        PasswordResetCode::updateOrCreate(
            ['email' => $email],
            [
                'code' => $code,
                'expires_at' => now()->addMinutes(10),
                'sent_at' => now(),
            ]
        );

        // Send email
        Mail::raw("Your ServEase password reset code is: {$code}. It expires in 10 minutes.", function ($message) use ($email) {
            $message->to($email)->subject('ServEase Password Reset Code');
        });

        // Store email in session
        session(['password_reset_email' => $email]);

        return redirect()->route('password.code.verify.form')
            ->with('status', 'Verification code sent successfully! Check your email.');
    }

    /**
     * Step 3: Show verify page
     */
    public function showVerifyForm()
    {
        return view('auth.verify-code');
    }

    /**
     * Step 4: Verify code
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $email = session('password_reset_email');

        if (!$email) {
            return redirect()->route('password.code.request')
                ->with('error', 'Session expired. Please request a new code.');
        }

        $reset = PasswordResetCode::where('email', $email)->first();

        if (!$reset || $reset->code != $request->code) {
            return back()->with('error', 'Invalid verification code.');
        }

        if (Carbon::parse($reset->expires_at)->isPast()) {
            return back()->with('error', 'Code has expired. Please request a new one.');
        }

        // Store verified email in session to allow password reset
        session(['verified_email' => $email]);

        return redirect()->route('password.reset.form')
            ->with('status', 'Code verified! You may now reset your password.');
    }
}
