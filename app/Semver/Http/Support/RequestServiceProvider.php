<?php
namespace Semver\Http\Support;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequestFactory;

class RequestServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        ServerRequestInterface::class,
    ];

    /**
     * Register method.
     */
    public function register()
    {
        // Bind the Symfony request to the container.
        $this->container->share(ServerRequestInterface::class, function () {
            return ServerRequestFactory::fromGlobals();
        });
    }
}
