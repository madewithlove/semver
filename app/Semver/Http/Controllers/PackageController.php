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
     * @type Client
     */
    private $client;

    /**
     * @type Request
     */
    private $request;

    /**
     * @type VersionParser
     */
    private $parser;

    /**
     * @param Request       $request
     * @param VersionParser $parser
     * @param Client        $client
     */
    public function __construct(Request $request, VersionParser $parser, Client $client)
    {
        $this->client  = $client;
        $this->request = $request;
        $this->parser  = $parser;
    }

    /**
     * @param string $vendor
     * @param string $package
     *
     * @return JsonResponse
     */
    public function versions($vendor, $package)
    {
        $versions = $this->getVersions($vendor, $package);
        foreach ($versions as $key => $version) {
            $versions[$version->getVersion()] = [
                'source'  => substr($version->getSource()->getUrl(), 0, -4),
                'version' => $version->getVersion(),
            ];
        }

        usort($versions, function ($a, $b) {
            return -1 * version_compare($a['version'], $b['version']);
        });

        return new JsonResponse($versions);
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

        $body       = json_decode($this->request->getContent(), true);
        $constraint = isset($body['constraint']) ? $body['constraint'] : '*';
        $constraint = $this->parser->parseConstraints($constraint);

        $matchedVersions = array_filter($versions, function (Version $version) use ($constraint) {
            return $constraint->matches(new VersionConstraint('==', $this->parser->normalize($version->getVersion())));
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
        /** @type Version[] $versions */
        $package  = $this->client->get("$vendor/$package");
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
     *
     * @return bool
     */
    protected function isDevVersion(Version $version)
    {
        return preg_match('/.*-dev/', $version->getVersion()) or preg_match('/dev-.*/', $version->getVersion());
    }
}
