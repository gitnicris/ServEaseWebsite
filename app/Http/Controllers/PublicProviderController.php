<?php

namespace App\Http\Controllers;

use App\Models\User;

class PublicProviderController extends Controller
{
    public function show(User $provider)
{
    // Make sure it’s a provider
    abort_unless($provider->role === 'provider', 404);

    $profile = $provider->providerProfile()
        ->with(['reviews.customer'])
        ->firstOrCreate(
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

    $averageRating = round($profile->reviews->avg('rating') ?? 0, 1);

    return view('providers.public-profile', compact('provider', 'profile', 'averageRating'));
}

}
