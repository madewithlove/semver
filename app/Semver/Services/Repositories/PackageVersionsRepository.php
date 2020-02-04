<?php

namespace Semver\Services\Repositories;

use Packagist\Api\Client;
use Packagist\Api\Result\Package\Version;
use Semver\Contracts\Repositories\PackageVersionsRepository as PackageVersionsRepositoryContract;

class PackageVersionsRepository implements PackageVersionsRepositoryContract
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $package vendor/package
     *
     * @return Version[]
     */
    public function getVersions($package)
    {
        $versions = $this->client->get($package)->getVersions();

        usort($versions, function (Version $a, Version $b) {
            return -1 * version_compare($a->getVersionNormalized(), $b->getVersionNormalized());
        });

        return $versions;
    }
}
