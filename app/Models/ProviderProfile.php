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
        'phone',
        'address',
        'photo',
    ];

    // 🔗 Relationship: Profile belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
