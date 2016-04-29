<?php
namespace Semver\Services\Cache;

use Illuminate\Cache\FileStore;
use Illuminate\Cache\Repository as IlluminateCache;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Filesystem\Filesystem;
use League\Container\ServiceProvider\AbstractServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        Repository::class,
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     */
    public function register()
    {
        $this->container->share(Repository::class, function () {
            $store = new FileStore(new Filesystem(), $this->container->get('paths.cache'));

            return new IlluminateCache($store);
        });
    }
}
