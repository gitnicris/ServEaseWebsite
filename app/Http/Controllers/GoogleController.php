<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    // Step 1: Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Step 2: Handle callback from Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt(Str::random(16)), // random password
                    'google_id' => $googleUser->getId(),
                ]
            );

            Auth::login($user);

            return redirect()->intended('/dashboard'); // change to your home route

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Failed to login with Google.');
        }
    }
}
