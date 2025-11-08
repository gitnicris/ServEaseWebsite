<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['provider_id', 'user_id', 'rating', 'comment'];

    public function provider()
    {
        // Link to ProviderProfile model
        return $this->belongsTo(ProviderProfile::class, 'provider_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
