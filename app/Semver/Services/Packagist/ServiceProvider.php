<?php
namespace Semver\Services\Packagist;

use League\Container\ServiceProvider as BaseServiceProvider;
use Packagist\Api\Client;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @type array
     */
    protected $provides = [
        Client::class,
        Packagist::class,
    ];

    /**
     * Register method.
     */
    public function register()
    {
        $this->container->singleton(Client::class);
        $this->container->singleton(Packagist::class);
    }
}
