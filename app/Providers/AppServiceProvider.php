<?php

namespace App\Providers;

use App\Packagist\ApiClient;
use App\Packagist\CachedApiClient;
use App\Packagist\Client;
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
        $this->app->singleton(
            Client::class,
            function () {
                if ($this->app->environment('local')) {
                    // no cache in the local environment
                    return $this->app->get(ApiClient::class);
                }

                return $this->app->get(CachedApiClient::class);
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
