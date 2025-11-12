<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Service;
use App\Models\ProviderProfile;
use App\Models\CustomerProfile;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'phone',
        'address',
        'photo',
        'role',
        'google_id',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //  A user (provider) can have many services
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // A provider has one profile
    public function providerProfile()
    {
        return $this->hasOne(ProviderProfile::class, 'user_id');
    }
    public function customerProfile()
{
    return $this->hasOne(CustomerProfile::class, 'user_id');
}


    // Helper to easily get user’s photo (fallback if missing)
    public function getProfilePhotoUrlAttribute()
{
    // Check Provider Profile first
    if ($this->providerProfile && $this->providerProfile->photo) {
        return asset('storage/' . $this->providerProfile->photo);
    }

    // Then check Customer Profile
    if ($this->customerProfile && $this->customerProfile->photo) {
        return asset('storage/' . $this->customerProfile->photo);
    }

    // If user has a direct photo column
    if ($this->photo) {
        return asset('storage/' . $this->photo);
    }

    // Fallback avatar
    return 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
}

   public function customerBookings()
{
    return $this->hasMany(Booking::class, 'customer_id');
}

public function providerBookings()
{
    return $this->hasMany(Booking::class, 'provider_id');
}
public function reviews()
{
    return $this->hasMany(Review::class);
}
public function profile()
{
    if ($this->role === 'provider') {
        return $this->providerProfile();
    }

    if ($this->role === 'customer') {
        return $this->customerProfile();
    }

    return null;
}


}
