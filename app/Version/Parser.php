<?php

namespace App\Version;

use Composer\Semver\Constraint\ConstraintInterface;
use Composer\Semver\VersionParser;
use Illuminate\Support\Str;
use UnexpectedValueException;

final readonly class Parser
{
    public function __construct(
        private VersionParser $versionParser
    ) {
    }

    public function parseConstraint(string $constraints): ConstraintInterface
    {
        if (Str::startsWith($constraints, '@')) {
            throw new UnexpectedValueException();
        }

        return $this->versionParser->parseConstraints($constraints);
    }

    public function normalize(string $version): string
    {
        return $this->versionParser->normalize($version);
    }

    public function parseStability(string $version): string
    {
        return VersionParser::parseStability($version);
    }
}
