<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    // Step 1: Redirect user to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // New user → create without assigning role yet
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(Str::random(16)),
                'google_id' => $googleUser->getId(),
            ]);

            Auth::login($user);

            // Redirect to role selection page
            return redirect()->route('choose.role');
        }

        Auth::login($user);

        // Redirect based on role
        if ($user->role === 'provider') {
            return redirect()->route('provider.dashboard');
        }

        return redirect()->route('customer.dashboard');
    } catch (\Exception $e) {
        return redirect('/login')->with('error', 'Failed to login with Google.');
    }
}


    // Optional: allow user to change role manually
    public function saveRole(Request $request)
    {
        $request->validate(['role' => 'required|in:customer,provider']);

        $user = Auth::user();
        $user->role = $request->role;
        $user->save();

        return $this->redirectBasedOnRole($user);
    }

    // Centralized role-based redirect
    protected function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->role === 'provider') {
            return redirect()->intended('/provider/dashboard');
        } else {
            return redirect()->intended('/customer/dashboard');
        }
    }
}
