<?php

namespace App\Providers;

use App\Http\Services\SmsService;
use App\Http\Services\TwilioClientService;
use App\Models\AdvertRequest;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            //$this->app->register(IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //AdvertRequest::disableSearchSyncing();

        $this->app->singleton(SmsService::class, static function(Application $app) {
            return new SmsService($app->make(TwilioClientService::class));
        });
    }
}
