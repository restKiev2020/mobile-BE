<?php

namespace App\Models;

use Carbon\Carbon;
use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    private const TOKEN_NAME = "realtorToken";


     const  AVAILABLE_STATUSES = [
        'PENDING' => 'pending',
        'STANDARD' => 'standard',
        'SILVER' => 'silver',
        'GOLD' => 'gold',
        'PLATINUM' => 'platinum'
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'second_phone',
        'third_phone',
        'messenger',
        'specialization',
        'password',
        'verified_at',
        'status',
        'blocked',
        'is_admin'
    ];

    protected $hidden = [
        'password',
        'pivot',
        'profile_picture'
    ];

    protected $appends = [
        //'documents_ids',
        'avatar',
        'web_token',
    ];

    protected $casts = [
        'blocked' => 'boolean',
        'is_admin' => 'boolean'
    ];

    public function getAccessToken()
    {
        return $this->createToken(self::TOKEN_NAME)->accessToken;
    }

    public function getAuthIdentifier()
    {
        Return $this->getKey();
    }
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function setPasswordAttribute(string $password) {
        $this->attributes['password'] = Hash::make($password);
    }

    public function comparePasswordHash(string $password) {
        return Hash::check($password, $this->getAuthPassword());
    }

    public function verify()
    {
        $this->attributes['verified_at'] = Carbon::now();
        $this->save();
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function getDocumentsIdsAttribute()
    {
        return $this->documents()->select(['id', 'url'])->get();
    }

    public function profilePicture()
    {
        return $this->belongsTo(Document::class, 'profile_picture', 'id');
    }

    public function getAvatarAttribute()
    {
        return $this->profilePicture()->select(['id', 'url'])->first();
    }

    public function getWebTokenAttribute()
    {
        return Crypt::encrypt($this->id);
    }

    public static function getIdFromWebToken(string $token)
    {
        return Crypt::decrypt($token);
    }

    public function favourites()
    {
        return $this->belongsToMany(Advert::class, 'user_advert_favourites', 'user_id', 'advert_id')->withTimestamps();
    }

    public function appointments()
    {
        return $this->belongsToMany(Advert::class, 'appointments', 'user_id', 'advert_id')->withTimestamps();
    }

    public function adverts() {
        return $this->hasMany(Advert::class);
    }

    public function advertRequests() {
        return $this->hasMany(AdvertRequest::class);
    }
}
