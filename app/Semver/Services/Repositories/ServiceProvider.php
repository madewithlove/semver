<?php
namespace Semver\Services\Repositories;

use Illuminate\Contracts\Cache\Repository;
use League\Container\ServiceProvider as BaseServiceProvider;
use Semver\Contracts\Repositories\PackageVersionsRepository as PackageVersionsRepositoryContract;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        PackageVersionsRepositoryContract::class,
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     */
    public function register()
    {
        $this->container->singleton(PackageVersionsRepositoryContract::class, function () {
            return new PackageVersionsCacheRepository(
                $this->container->get(Repository::class),
                $this->container->get(PackageVersionsRepository::class)
            );
        });
    }
}
