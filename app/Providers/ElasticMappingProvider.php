<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ElasticMappingProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(app_path() . '/Elastic/Advert/elastic-advert-config.php', 'elastic-advert');
        $this->mergeConfigFrom(app_path() . '/Elastic/AdvertRequest/elastic-advert-request-config.php', 'elastic-advert-request');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
