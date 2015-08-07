<?php

namespace Semver\Services\Repositories;

use Illuminate\Contracts\Cache\Repository;
use League\Container\ServiceProvider as BaseServiceProvider;
use Packagist\Api\Client;
use Semver\Services\Packagist\PackageVersionsRepository as PackageVersionsRepositoryInterface;

class ServiceProvider extends BaseServiceProvider
{
	/**
	 * @var array
	 */
	protected $provides = [
		PackageVersionsRepositoryInterface::class,
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
		$this->container->singleton(PackageVersionsRepositoryInterface::class, function() {
			return new PackageVersionsCacheRepository(
				$this->container->get(Repository::class),
				$this->container->get(PackageVersionsRepository::class)
			);
		});
	}
}