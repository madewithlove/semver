<?php

namespace App\Providers;

use App\Packagist\CachedApiClient;
use App\Packagist\Client;
use App\VirtualPackages\VirtualPackageEnrichingApiClient;
use App\VirtualPackages\VirtualPackageFactory;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

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
                        VirtualPackageFactory::php(),
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

        $this->bootRoute();
    }

    public function bootRoute(): void
    {
        RateLimiter::for('api', function (Request $request) {
            /** @phpstan-ignore-next-line */
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });


    }
}
