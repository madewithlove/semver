<?php

namespace Semver\Services\Repositories;

use Illuminate\Contracts\Cache\Repository;
use Packagist\Api\Result\Package\Version;
use Semver\Contracts\Repositories\PackageVersionsRepository;

class PackageVersionsCacheRepository implements PackageVersionsRepository
{
    /**
     * @var Repository
     */
    private $cache;

    /**
     * @var PackageVersionsRepository
     */
    private $innerRepository;

    /**
     * @var int
     */
    private $ttl;

    /**
     * @param Repository                $cache
     * @param PackageVersionsRepository $innerRepository
     * @param int                       $ttl
     */
    public function __construct(Repository $cache, PackageVersionsRepository $innerRepository, $ttl = 60)
    {
        $this->cache = $cache;
        $this->innerRepository = $innerRepository;
        $this->ttl = $ttl;
    }

    /**
     * @param string $package vendor/package
     *
     * @return Version[]
     */
    public function getVersions($package)
    {
        return $this->cache->remember($package, $this->ttl, function () use ($package) {
            return $this->innerRepository->getVersions($package);
        });
    }
}
