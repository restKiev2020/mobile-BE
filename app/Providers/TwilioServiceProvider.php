<?php

namespace App\Providers;

use App\Http\Services\TwilioClientService;
use Illuminate\Support\ServiceProvider;
use Twilio\Exceptions\ConfigurationException;

class TwilioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws ConfigurationException
     */
    public function boot()
    {
        if(
            !config('twilio.twilio_sid') &&
            !config('twilio.twilio_token') &&
            !config('twilio.phone_number')
        ) {
            throw new ConfigurationException('Twilio configuration variables are not set. Check the .env file');
        }

        $this->app->singleton(TwilioClientService::class, function ($app) {
            return new TwilioClientService();
        });
    }
}
