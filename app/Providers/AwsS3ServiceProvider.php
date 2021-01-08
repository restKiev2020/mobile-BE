<?php

namespace App\Providers;

use App\Http\Services\AwsS3Service;
use Illuminate\Support\ServiceProvider;

class AwsS3ServiceProvider extends ServiceProvider
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
     */
    public function boot()
    {
        if(
            !config('aws.credentials.key') &&
            !config('aws.credentials.secret') &&
            !config('aws.region') &&
            !config('aws.version')
        ) {
            throw new \RuntimeException('Aws configuration variables are not set. Check the .env file');
        }

        $this->app->singleton(AwsS3Service::class, function ($app) {
            return new AwsS3Service();
        });
    }
}
