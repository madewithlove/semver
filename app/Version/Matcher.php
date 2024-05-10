<?php

declare(strict_types=1);

namespace App\Version;

use Composer\Package\BasePackage;
use Composer\Semver\Constraint\Constraint;
use UnexpectedValueException;

final readonly class Matcher
{
    public function __construct(
        private Parser $parser,
    ) {
    }

    public function matches(string $version, string $constraint, string $requiredStability): bool
    {
        try {
            $constraint = $this->parser->parseConstraint($constraint);
        } catch (UnexpectedValueException) {
            return false;
        }

        $parsedVersion = new Constraint('=', $this->parser->normalize($version));

        if (! $parsedVersion->matches($constraint)) {
            return false;
        }

        if (! $this->isMoreOrEquallyStable($version, $requiredStability)) {
            return false;
        }

        return true;
    }

    private function isMoreOrEquallyStable(string $version, string $requiredStability): bool
    {
        $stability = $this->parser->parseStability($version);

        return BasePackage::$stabilities[$stability] <= BasePackage::$stabilities[$requiredStability];
    }
}
