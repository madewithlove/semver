<?php

namespace Semver\Services\Paths;

use League\Container\ServiceProvider\AbstractServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        'paths.app',
        'paths.base',
        'paths.views',
    ];

    /**
     * Register method.
     */
    public function register()
    {
        $this->container->add('paths.base', realpath(__DIR__.'/../../../..').'/');

        $paths = [
            'app' => 'app',
            'cache' => 'cache',
            'views' => 'resources/views',
        ];

        foreach ($paths as $name => $relative) {
            $this->container->add('paths.'.$name, function () use ($relative) {
                return $this->container->get('paths.base').$relative.'/';
            });
        }
    }
}
