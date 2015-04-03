<?php
namespace Semver\Http\Support;

use League\Container\ServiceProvider;
use League\Route\RouteCollection;
use League\Route\Strategy\UriStrategy;

class RoutesServiceProvider extends ServiceProvider
{
    /**
     * @type array
     */
    protected $provides = [
        RouteCollection::class,
        'routes.file',
    ];

    /**
     * @param RouteCollection $router
     */
    public function boot(RouteCollection $router)
    {
        include $this->container->get('routes.file');
    }

    /**
     * Register method,.
     */
    public function register()
    {
        $this->container->add('routes.file', function () {
            return $this->container->get('paths.app').'routes.php';
        });

        // Bind a route collection to the container.
        $this->container->singleton(RouteCollection::class, function () {
            $routes = new RouteCollection($this->container);
            $routes->setStrategy(new UriStrategy());

            return $routes;
        });
    }
}
