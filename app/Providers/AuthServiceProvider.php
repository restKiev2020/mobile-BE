<?php

namespace App\Providers;

use Gate;
use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Passport::routes();

        Passport::tokensExpireIn(now()->addMonth());

        Passport::refreshTokensExpireIn(now()->addMonths(10));

        Gate::define('can-update-model', function($user, $otherId) {
            return $user->is_admin || $user->id === (int) $otherId;
        });

        Gate::define('view-full-advert', function($user, $advert) {
           return  $user->id === $advert->user_id;
        });

    }
}
