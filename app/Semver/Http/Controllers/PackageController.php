<?php
namespace Semver\Http\Controllers;

use Composer\Package\LinkConstraint\VersionConstraint;
use Composer\Package\Version\VersionParser;
use Packagist\Api\Client;
use Packagist\Api\Result\Package\Version;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PackageController
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Request
     */
    private $request;

    /**
     * @param Client  $client
     */
    public function __construct(Request $request, Client $client)
    {
        $this->client = $client;
        $this->request = $request;
    }

    /**
     * @param string $vendor
     * @param string $package
     *
     * @return JsonResponse
     */
    public function versions($vendor, $package)
    {
        return new JsonResponse(array_keys($this->getVersions($vendor, $package)));
    }

    /**
     * @param string $vendor
     * @param string $package
     *
     * @return JsonResponse
     */
    public function matchVersions($vendor, $package)
    {
        $versions = $this->getVersions($vendor, $package);

        $parser = new VersionParser();
        $constraint = $this->request->get('constraint');

        $constraint = $parser->parseConstraints($constraint);

        $matchedVersions = array_filter($versions, function (Version $version) use ($constraint) {
            return $constraint->matches(new VersionConstraint('==', $version->getVersion()));
        });

        return new JsonResponse(array_keys($matchedVersions));
    }

    /**
     * @param string $vendor
     * @param string $package
     *
     * @return array
     */
    protected function getVersions($vendor, $package)
    {
        $package = $this->client->get("$vendor/$package");

        /** @var array $versions */
        $versions = $package->getVersions();

        return array_filter(
            $versions,
            function (Version $version) {
                return !$this->isDevVersion($version);
            }
        );
    }

    /**
     * @param Version $version
     * @return bool
     */
    protected function isDevVersion(Version $version)
    {
        return preg_match('/.*-dev/', $version->getVersion()) or preg_match('/dev-.*/', $version->getVersion());
    }
}
