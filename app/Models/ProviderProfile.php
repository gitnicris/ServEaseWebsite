<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'bio',
        'address',
        'gmail',
        'phone',
        'photo',
        'about',
        'review',
    ];

    // 🔗 Relationship: Profile belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reviews()
{
    return $this->hasMany(Review::class, 'provider_id', 'user_id');
}
public function getPhotoUrlAttribute()
{
    if ($this->photo && \Storage::disk('public')->exists($this->photo)) {
        return asset('storage/' . $this->photo);
    }

    return 'https://ui-avatars.com/api/?name=' . urlencode($this->name ?? $this->user->name);
}


}
