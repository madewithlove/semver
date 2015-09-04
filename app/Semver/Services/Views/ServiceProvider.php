<?php
namespace Semver\Services\Views;

use League\Container\ServiceProvider as BaseServiceProvider;
use League\Plates\Engine;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Engine::class,
    ];

    /**
     * Register method.
     */
    public function register()
    {
        $this->container->add(Engine::class, function () {
            return new Engine($this->container->get('paths.views'));
        });
    }
}
