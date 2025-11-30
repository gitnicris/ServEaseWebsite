<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'bio',
        'phone',
        'address',
        'photo',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getPhotoUrlAttribute()
{
    if ($this->photo && \Storage::disk('public')->exists($this->photo)) {
        return asset('storage/' . $this->photo);
    }

    return 'https://ui-avatars.com/api/?name=' . urlencode($this->name ?? $this->user->name);
}

}
