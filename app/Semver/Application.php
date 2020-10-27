<?php

namespace Semver;

use League\Container\Container;
use League\Container\ReflectionContainer;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\Dispatcher;
use League\Route\RouteCollection;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;

class Application
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var string[]
     */
    protected $serviceProviders = [
        Http\Support\RoutesServiceProvider::class,
        Http\Support\RequestServiceProvider::class,
        Services\Paths\ServiceProvider::class,
        Services\Error\ServiceProvider::class,
        Services\Packagist\ServiceProvider::class,
        Services\Views\ServiceProvider::class,
        Services\Cache\ServiceProvider::class,
        Services\Repositories\ServiceProvider::class,
    ];

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->container->delegate(new ReflectionContainer());

        $this->setupProviders();
    }

    /**
     * Run the application.
     */
    public function run()
    {
        /* @var Dispatcher $dispatcher */
        /* @type ServerRequestInterface $request */
        $request = $this->container->get(ServerRequestInterface::class);

        // Hack to fix issue with phar in URI
        if($request->getUri()->getPath() == '/packages/psalm/phar') {
            $request = $request->withUri($request->getUri()->withPath('/packages/psalm/p-h-a-r'));
        }

        $response = new Response();
        $dispatcher = $this->container->get(RouteCollection::class);

        $response = $dispatcher->dispatch($request, $response);

        (new SapiEmitter())->emit($response);
    }

    /**
     * Register the providers with the container.
     */
    private function setupProviders()
    {
        foreach ($this->serviceProviders as &$serviceProvider) {
            /** @var AbstractServiceProvider $serviceProvider */
            $serviceProvider = new $serviceProvider();
            $serviceProvider->setContainer($this->container);
        }

        // Register the service providers.
        array_walk($this->serviceProviders, function (AbstractServiceProvider $serviceProvider) {
            $this->container->addServiceProvider($serviceProvider);
        });

        // Call the boot methods.
        array_walk($this->serviceProviders, function (AbstractServiceProvider $serviceProvider) {
            if (method_exists($serviceProvider, 'boot')) {
                $this->container->call([$serviceProvider, 'boot']);
            }
        });
    }
}
