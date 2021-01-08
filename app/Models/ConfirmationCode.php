<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ConfirmationCode extends Model
{
    public const EXPIRATION_MINUTES = 30;

    protected $fillable = [
        'code',
        'exp'
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(static function (self $model) {
            $code = random_int(100000, 999999);

            $model->attributes['code'] = $code;
            $model->attributes['exp'] = Carbon::now()->addMinutes(15);
        });
    }

    public function scopeNotExpired(Builder $query)
    {
        $query->whereDate('exp', '>=', Carbon::now()->subMinutes(self::EXPIRATION_MINUTES));
    }

    public function scopeExpired(Builder $query)
    {
        $query->whereDate('exp', '<', Carbon::now()->subMinutes(self::EXPIRATION_MINUTES));
    }
}
