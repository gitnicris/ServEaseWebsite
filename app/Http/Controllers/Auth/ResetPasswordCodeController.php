<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordCodeController extends Controller
{
    public function showResetForm()
    {
        if (!session('verified_email')) {
            return redirect()->route('password.code.request')
                ->with('error', 'Unauthorized action.');
        }

        return view('auth.reset-password-code');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email = session('verified_email');
        $user = User::where('email', $email)->firstOrFail();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Clear sessions
        session()->forget(['verified_email', 'password_reset_email']);

        return redirect()->route('login')
            ->with('status', 'Password updated successfully! You may now log in.');
    }
}
