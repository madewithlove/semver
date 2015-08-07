<?php
namespace Semver\Services\Cache;

use Illuminate\Cache\FileStore;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Cache\Repository as IlluminateCache;
use Illuminate\Filesystem\Filesystem;
use League\Container\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @type array
     */
    protected $provides = [
        Repository::class,
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->container->singleton(Repository::class, function () {
            $store = new FileStore(new Filesystem(), $this->container->get('paths.cache'));

            return new IlluminateCache($store);
        });
    }
}
