<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    /**
     * Show the reset password form.
     */
    public function create(Request $request)
    {
        // Get the verified email saved from the code verification step
        $email = session('verified_email');

        if (!$email) {
            return redirect()->route('password.request')->withErrors([
                'email' => 'Your reset session expired. Please try again.'
            ]);
        }

        return view('auth.reset-password', compact('email'));
    }

    /**
     * Handle resetting the password after verification.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Find the user
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email not found.']);
        }

        // Update the password
        $user->password = Hash::make($request->password);
        $user->save();

        // Clear session data
        session()->forget(['verified_email', 'reset_code']);

        return redirect()->route('login')
            ->with('status', 'Your password has been reset successfully.');
    }
}
