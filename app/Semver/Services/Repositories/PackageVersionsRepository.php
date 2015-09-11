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

    /**
     * @param Client $client
     */
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
        $package = $this->client->get($package);

        return $package->getVersions();
    }
}
