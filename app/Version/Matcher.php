<?php declare(strict_types=1);

namespace App\Version;

use Composer\Package\BasePackage;
use Composer\Semver\Constraint\Constraint;
use Composer\Semver\VersionParser;

final class Matcher
{
    private VersionParser $parser;

    public function __construct(VersionParser $versionParser)
    {
        $this->versionParser = $versionParser;
    }

    public function matches(string $version, string $constraint, string $requiredStability): bool
    {
        $constraint = $this->versionParser->parseConstraints($constraint);
        $parsedVersion = new Constraint('=', $this->versionParser->normalize($version));

        if (!$parsedVersion->matches($constraint)) {
            return false;
        }

        if (!$this->isMoreOrEquallyStable($version, $requiredStability)) {
            return false;
        }

        return true;
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
        $stability = $this->versionParser->parseStability($version);

        return BasePackage::$stabilities[$stability] <= BasePackage::$stabilities[$requiredStability];
    }
}