<?php declare(strict_types=1);

namespace App\Version;

use Composer\Package\BasePackage;
use Composer\Semver\Constraint\Constraint;
use Composer\Semver\VersionParser;

final class Matcher
{
    public function __construct(
        private VersionParser $versionParser
    ) {}

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

    private function isMoreOrEquallyStable(string $version, string $requiredStability): bool
    {
        $stability = $this->versionParser->parseStability($version);

        return BasePackage::$stabilities[$stability] <= BasePackage::$stabilities[$requiredStability];
    }
}
