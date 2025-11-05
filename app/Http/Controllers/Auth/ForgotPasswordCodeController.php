<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class ForgotPasswordCodeController extends Controller
{
    // Step 1: Show email form
    public function showEmailForm()
    {
        return view('auth.forgot-password-code');
    }

    // Step 2: Send verification code via email
    public function sendCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with this email.']);
        }

        $code = rand(100000, 999999);

        // Save code and expiration
        DB::table('password_reset_codes')->updateOrInsert(
            ['email' => $request->email],
            [
                'code' => $code,
                'created_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addMinutes(10),
            ]
        );

        // Send email with code
        Mail::raw("Your ServEase verification code is: {$code}", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('ServEase Password Reset Code');
        });

        return redirect()->route('password.code.verify.form')
                         ->with('success', 'A verification code has been sent to your email.');
    }

    // Step 3: Show code verification form
    public function showVerifyForm()
    {
        return view('auth.verify-code');
    }

    // Step 4: Verify code
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
        ]);

        $record = DB::table('password_reset_codes')
                    ->where('email', $request->email)
                    ->where('code', $request->code)
                    ->first();

        if (!$record) {
            return back()->withErrors(['code' => 'Invalid verification code.']);
        }

        if (Carbon::parse($record->expires_at)->isPast()) {
            return back()->withErrors(['code' => 'Verification code has expired.']);
        }

        session(['password_reset_email' => $request->email]);

        return redirect()->route('password.reset.form');
    }

    // Step 5: Show reset password form
    public function showResetForm()
    {
        return view('auth.reset-password-code');
    }

    // Step 6: Reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $email = session('password_reset_email');

        if (!$email) {
            return redirect()->route('password.code.request')
                             ->withErrors(['email' => 'Please start the reset process again.']);
        }

        User::where('email', $email)->update([
            'password' => Hash::make($request->password),
        ]);

        // Remove used code
        DB::table('password_reset_codes')->where('email', $email)->delete();

        session()->forget('password_reset_email');

        return redirect()->route('login')->with('success', 'Password has been reset successfully.');
    }
}
