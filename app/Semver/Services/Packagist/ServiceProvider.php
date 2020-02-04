<?php

namespace Semver\Services\Packagist;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface;
use League\Container\ServiceProvider\AbstractServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        ClientInterface::class,
    ];

    /**
     * Register method.
     */
    public function register()
    {
        // Alias for Guzzle's ClientInterface for the first argument of Packagist\Api\Client.
        $this->container->add(ClientInterface::class, function () {
            return $this->container->get(HttpClient::class);
        });
    }
}
