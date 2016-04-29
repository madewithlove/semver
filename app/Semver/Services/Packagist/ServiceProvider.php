<?php
namespace Semver\Services\Packagist;

use Guzzle\Http\Client as HttpClient;
use Guzzle\Http\ClientInterface;
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
