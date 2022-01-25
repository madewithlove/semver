<?php

namespace App\Providers;

use App\Packagist\CachedApiClient;
use App\Packagist\Client;
use App\VirtualPackages\VirtualPackageFactory;
use App\VirtualPackages\VirtualPackageEnrichingApiClient;
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
                /** @var CachedApiClient $cachedClient */
                $cachedClient = $this->app->get(CachedApiClient::class);

                return new VirtualPackageEnrichingApiClient(
                    $cachedClient,
                    [
                        VirtualPackageFactory::php()
                    ]
                );
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
