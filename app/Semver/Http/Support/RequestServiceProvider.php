<?php
namespace Semver\Http\Support;

use League\Container\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class RequestServiceProvider extends ServiceProvider
{
    /**
     * @type array
     */
    protected $provides = [
        Request::class,
    ];

    /**
     * Register method.
     */
    public function register()
    {
        // Bind the Symfony request to the container.
        $this->container->singleton(Request::class, function () {
            return Request::createFromGlobals();
        });
    }
}
