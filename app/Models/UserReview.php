<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
    protected $fillable = [
        'review',
        'rating',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
