<?php
namespace Semver\Services\Packagist;

use Composer\DependencyResolver\Pool;
use Composer\Package\BasePackage;
use Composer\Package\LinkConstraint\VersionConstraint;
use Composer\Package\Package;
use Composer\Package\Version\VersionParser;
use Composer\Package\Version\VersionSelector;
use Packagist\Api\Result\Package\Version;

class Packagist
{
    /**
     * @type VersionParser
     */
    private $parser;

    /**
     * @type string
     */
    protected $minimumStability = 'stable';

    /**
     * @var PackageVersionsRepository
     */
    private $versionsRepository;

    /**
     * @param VersionParser $parser
     * @param PackageVersionsRepository $versionsRepository
     */
    public function __construct(VersionParser $parser, PackageVersionsRepository $versionsRepository)
    {
        $this->parser = $parser;
        $this->versionsRepository = $versionsRepository;
    }

    /**
     * @return string
     */
    public function getMinimumStability()
    {
        return $this->minimumStability;
    }

    /**
     * @param string $minimumStability
     */
    public function setMinimumStability($minimumStability)
    {
        $this->minimumStability = $minimumStability;
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
     *
     * @return array
     */
    public function getMatchingVersions($vendor, $package, $constraint = '*')
    {
        $versions = $this->getRawVersions($vendor, $package);

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
        $highestStability = $this->parser->parseStability($highestVersion);

        foreach ($versions as $version) {
            $nomalizedVersion = $this->parser->normalize($version);
            $nomalizedHighestVersion = $this->parser->normalize($highestVersion);

            if ($this->isMoreStable($version, $highestStability) ||
                version_compare($nomalizedHighestVersion, $nomalizedVersion, '<')
            ) {
                $highestVersion = $version;
                $highestStability = $this->parser->parseStability($version);
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
     *
     * @return array
     */
    private function getRawVersions($vendor, $package)
    {
        /* @type Version[] $versions */
        $versions = $this->versionsRepository->getVersions("$vendor/$package");

        return array_filter(
            $versions,
            function (Version $version) {
                return $this->isMoreOrEquallyStable($version->getVersion(), $this->minimumStability);
            }
        );
    }

    /**
     * Helper method.
     *
     * @param string $version
     * @param string $requiredStability
     *
     * @return bool
     */
    private function isMoreOrEquallyStable($version, $requiredStability)
    {
        $stability = $this->parser->parseStability($version);

        return BasePackage::$stabilities[$stability] <= BasePackage::$stabilities[$requiredStability];
    }

    /**
     * Helper method.
     *
     * @param string $version
     * @param string $requiredStability
     *
     * @return bool
     */
    private function isMoreStable($version, $requiredStability)
    {
        $stability = $this->parser->parseStability($version);

        return BasePackage::$stabilities[$stability] < BasePackage::$stabilities[$requiredStability];
    }
}
