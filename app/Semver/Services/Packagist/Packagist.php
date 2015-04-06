<?php
namespace Semver\Services\Packagist;

use Composer\Package\LinkConstraint\VersionConstraint;
use Composer\Package\Version\VersionParser;
use Packagist\Api\Client;
use Packagist\Api\Result\Package\Version;

class Packagist
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var VersionParser
     */
    private $parser;

    /**
     * @param Client        $client
     * @param VersionParser $parser
     */
    public function __construct(Client $client, VersionParser $parser)
    {
        $this->client = $client;
        $this->parser = $parser;
    }

    /**
     * @param string $vendor
     * @param string $package
     *
     * @return array
     */
    public function getVersions($vendor, $package)
    {
        $versions = $this->getRawVersions($vendor, $package);

        foreach ($versions as $key => &$version) {
            /** @type Version $version */
            $versions[$version->getVersion()] = [
                'source'  => substr($version->getSource()->getUrl(), 0, -4),
                'version' => $version->getVersion(),
            ];
        }

        usort($versions, function ($a, $b) {
            return -1 * version_compare($a['version'], $b['version']);
        });

        return $versions;
    }

    /**
     * @param string $vendor
     * @param string $package
     * @param string $constraint
     * @param string $minStability
     *
     * @return array
     */
    public function getMatchingVersions($vendor, $package, $constraint = '*', $minStability = 'stable')
    {
        $versions = $this->getRawVersions($vendor, $package);

        $constraint = $this->parser->parseConstraints($constraint);

        return array_keys(array_filter($versions, function (Version $version) use ($constraint) {
            return $constraint->matches(new VersionConstraint('==', $this->parser->normalize($version->getVersion())));
        }));
    }

    /**
     * @param string $vendor
     * @param string $package
     *
     * @return array
     */
    private function getRawVersions($vendor, $package)
    {
        /* @type Version[] $versions */
        $package  = $this->client->get("$vendor/$package");
        $versions = $package->getVersions();

        return array_filter(
            $versions,
            function (Version $version) {
                return !$this->isVolatileVersion($version);
            }
        );
    }

    /**
     * @param Version $version
     *
     * @return bool
     */
    protected function isVolatileVersion(Version $version)
    {
        return preg_match('/.*-dev/', $version->getVersion()) or preg_match('/dev-.*/', $version->getVersion());
    }
} 