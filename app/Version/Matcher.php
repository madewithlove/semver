<?php declare(strict_types=1);

namespace App\Version;

final class Matcher
{
    public function matches(string $version, string $constraint, string $stability): bool
    {
        return $version === $constraint;
    }
}
