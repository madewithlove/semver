<?php

namespace Semver\Http\Support;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\RouteCollection;
use League\Route\Strategy\ParamStrategy;
use Semver\Http\Controllers\HomeController;
use Semver\Http\Controllers\PackageController;

class RoutesServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        RouteCollection::class,
    ];

    /**
     * Register method,.
     */
    public function register()
    {
        // Bind a route collection to the container.
        $this->container->share(RouteCollection::class, function () {
            $strategy = new ParamStrategy();
            $strategy->setContainer($this->container);

            $routes = new RouteCollection($this->container);
            $routes->setStrategy($strategy);

            return $routes;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot(RouteCollection $router)
    {
        $router->get('/', HomeController::class.'::index');
        $router->get('/packages/{vendor}/{package}', PackageController::class.'::versions');
        $router->get('/packages/{vendor}/{package}/match', PackageController::class.'::matchVersions');
    }
}
