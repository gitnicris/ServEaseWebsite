<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'category',
        'image',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // The user/provider who owns this service
    public function provider()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
