<?php

namespace Semver\Http\Support;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\RouteCollection;
use League\Route\Strategy\ParamStrategy;

class RoutesServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        RouteCollection::class,
        'routes.file',
    ];

    /**
     * Register method,.
     */
    public function register()
    {
        $this->container->add('routes.file', function () {
            return $this->container->get('paths.app').'routes.php';
        });

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
        include $this->container->get('routes.file');
    }
}
