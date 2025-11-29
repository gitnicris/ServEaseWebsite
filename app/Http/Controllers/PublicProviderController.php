<?php

namespace App\Http\Controllers;

use App\Models\User;

class PublicProviderController extends Controller
{
    public function show(User $provider)
    {
        // Make sure it’s a provider
        abort_unless($provider->role === 'provider', 404);

        // Create profile if it doesn't exist
        $profile = $provider->providerProfile()->firstOrCreate(
            ['user_id' => $provider->id],
            [
                'name'    => $provider->name,
                'bio'     => '',
                'address' => '',
                'gmail'   => $provider->email ?? '',
                'phone'   => '',
                'photo'   => null,
                'about'   => '',
            ]
        );

        // Paginate reviews to avoid memory issues
        $reviews = $profile->reviews()->with('customer')->latest()->paginate(5);

        // Average rating can still be calculated via query without loading all reviews
        $averageRating = round($profile->reviews()->avg('rating') ?? 0, 1);

        return view('providers.public-profile', compact('provider', 'profile', 'reviews', 'averageRating'));
    }
}
