<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'provider_id',
        'customer_id',
        'rating',
        'comment',
    ];

    /**
     * The service being reviewed
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * The provider (User with role = provider)
     */
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    /**
     * The customer (User with role = customer) who left the review
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
