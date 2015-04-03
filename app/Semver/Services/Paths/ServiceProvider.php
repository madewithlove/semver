<?php
namespace Semver\Services\Paths;

use League\Container\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        'paths.app',
    ];

    /**
     * Register method.
     */
    public function register()
    {
        $this->container->add('paths.app', realpath(__DIR__.'/../../..').'/');
    }
}