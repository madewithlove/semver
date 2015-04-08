<?php
namespace Semver\Services\Packagist;

use Composer\DependencyResolver\Pool;
use Composer\Package\BasePackage;
use Composer\Package\LinkConstraint\VersionConstraint;
use Composer\Package\Package;
use Composer\Package\Version\VersionParser;
use Composer\Package\Version\VersionSelector;
use Illuminate\Cache\Repository;
use Packagist\Api\Client;
use Packagist\Api\Result\Package\Version;

class Packagist
{
    /**
     * @type Client
     */
    private $client;

    /**
     * @type VersionParser
     */
    private $parser;

    /**
     * @type Repository
     */
    private $cache;

    /**
     * @param Client        $client
     * @param VersionParser $parser
     * @param Repository    $cache
     */
    public function __construct(Client $client, VersionParser $parser, Repository $cache)
    {
        $this->client = $client;
        $this->parser = $parser;
        $this->cache  = $cache;
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
            /* @type Version $version */
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
     * @param string $minimumStability
     *
     * @return array
     */
    public function getMatchingVersions($vendor, $package, $constraint = '*', $minimumStability = 'stable')
    {
        $versions = $this->getRawVersions($vendor, $package, $minimumStability);

        $constraint = $this->parser->parseConstraints($constraint);

        return array_keys(array_filter($versions, function (Version $version) use ($constraint) {
            return $constraint->matches(new VersionConstraint('==', $this->parser->normalize($version->getVersion())));
        }));
    }

    /**
     * Given a concrete package, this returns a ~ constraint (in the future a ^ constraint)
     * that should be used, for example, in composer.json.
     * For example:
     *  * 1.2.1         -> ~1.2
     *  * 1.2           -> ~1.2
     *  * v3.2.1        -> ~3.2
     *  * 2.0-beta.1    -> ~2.0@beta
     *
     * @param string $vendor
     * @param string $package
     *
     * @return string
     */
    public function getDefaultConstraint($vendor, $package)
    {
        // Get versions.
        $versions = array_keys($this->getRawVersions($vendor, $package));

        // Get highest version.
        $highestVersion = reset($versions);
        foreach ($versions as $version) {
            if (version_compare($highestVersion, $version, '<')) {
                $highestVersion = $version;
            }
        }

        // Let version selector format the constraint.
        $selector = new VersionSelector(new Pool());
        $package  = new Package("$vendor/$package", $this->parser->normalize($highestVersion), $highestVersion);

        return $selector->findRecommendedRequireVersion($package);
    }

    /**
     * @param string $vendor
     * @param string $package
     * @param string $minimumStability
     *
     * @return array
     */
    private function getRawVersions($vendor, $package, $minimumStability = 'dev')
    {
        $handle   = "$vendor/$package";
        $lifetime = 60 * 24;

        /* @type Version[] $versions */
        $versions = $this->cache->remember($handle, $lifetime, function () use ($handle) {
            $package  = $this->client->get($handle);
            $versions = $package->getVersions();

            return $versions;
        });

        return array_filter(
            $versions,
            function (Version $version) use ($minimumStability) {
                $stability = $this->parser->parseStability($version->getVersion());

                return BasePackage::$stabilities[$stability] <= BasePackage::$stabilities[$minimumStability];
            }
        );
    }
}
