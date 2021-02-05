<?php declare(strict_types=1);

namespace App\Version;

use Composer\Semver\Constraint\Constraint;
use Composer\Semver\VersionParser;

final class Matcher
{
    private VersionParser $parser;

    public function __construct(VersionParser $versionParser)
    {
        $this->versionParser = $versionParser;
    }

    public function matches(string $version, string $constraint, string $stability): bool
    {
        $constraint = $this->versionParser->parseConstraints($constraint);

        return $constraint->matches(
            new Constraint('=', $this->versionParser->normalize($version))
        );
    }
}
