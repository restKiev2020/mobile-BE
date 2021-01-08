<?php


namespace Nedvibot\Realtor\Model;


use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Laravel\Passport\HasApiTokens;

/**
 * Class RealtorEloquent
 * @package Nedvibot\Realtor\Model
 */
class RealtorEloquent extends Model implements AuthenticatableContract, CanResetPasswordContract, AuthorizableContract
{
    use \Illuminate\Auth\Authenticatable, CanResetPassword, Authorizable, HasApiTokens;

    /**
     *
     */
    const REALTOR_TOKEN_NAME = 'realtorToken';
}
