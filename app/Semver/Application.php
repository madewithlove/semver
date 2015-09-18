<?php
namespace Semver;

use League\Container\ContainerInterface;
use League\Container\ServiceProvider;
use League\Route\Dispatcher;
use League\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;

class Application
{
    /**
     * @var ContainerInterface
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

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->setupProviders();
    }

    /**
     * Run the application.
     */
    public function run()
    {
        /** @var Dispatcher $dispatcher */
        /* @type Request $request */
        $dispatcher = $this->container->get(RouteCollection::class)->getDispatcher();
        $request = $this->container->get(Request::class);

        $response = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());

        $response->send();
    }

    /**
     * Register the providers with the container.
     */
    private function setupProviders()
    {
        foreach ($this->serviceProviders as &$serviceProvider) {
            /** @var ServiceProvider $serviceProvider */
            $serviceProvider = new $serviceProvider();
            $serviceProvider->setContainer($this->container);
        }

        // Register the service providers.
        array_walk($this->serviceProviders, function (ServiceProvider $serviceProvider) {
            $this->container->addServiceProvider($serviceProvider);
        });

        // Call the boot methods.
        array_walk($this->serviceProviders, function (ServiceProvider $serviceProvider) {
            if (method_exists($serviceProvider, 'boot')) {
                $this->container->call([$serviceProvider, 'boot']);
            }
        });
    }
}
