<?php
namespace Semver\Http\Controllers;

use Packagist\Api\Client;
use Packagist\Api\Result\Package\Version;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PackageController
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $vendor
     * @param string $package
     *
     * @return Response
     */
    public function versions($vendor, $package)
    {
        $package = $this->client->get("$vendor/$package");

        $versions = array_keys($package->getVersions());

        return new JsonResponse($versions);
    }
}
