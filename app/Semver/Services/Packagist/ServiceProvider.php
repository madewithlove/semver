<?php
namespace Semver\Services\Packagist;

use League\Container\ServiceProvider as BaseServiceProvider;
use Packagist\Api\Client;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Client::class,
    ];

    /**
     * Register method.
     */
    public function register()
    {
        $this->container->singleton(Client::class);
    }
}