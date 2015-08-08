<?php

namespace Semver\Services\Repositories;

use Illuminate\Contracts\Cache\Repository;
use Packagist\Api\Result\Package\Version;
use Semver\Services\Packagist\PackageVersionsRepository;

class PackageVersionsCacheRepository implements PackageVersionsRepository
{
	const CACHE_TTL = 60;

	/**
	 * @var Repository
	 */
	private $cache;

	/**
	 * @var PackageVersionsRepository
	 */
	private $innerRepository;

	/**
	 * @param Repository $cache
	 * @param PackageVersionsRepository $innerRepository
	 */
	public function __construct(Repository $cache, PackageVersionsRepository $innerRepository)
	{
		$this->cache = $cache;
		$this->innerRepository = $innerRepository;
	}

	/**
	 * @param string $package vendor/package
	 * @return Version[]
	 */
	public function getVersions($package)
	{
		return $this->cache->remember($package, static::CACHE_TTL, function () use ($package) {
			return $this->innerRepository->getVersions($package);
		});
	}
}