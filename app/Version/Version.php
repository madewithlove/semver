<?php

declare(strict_types=1);

namespace App\Version;

final class Version
{
    public function __construct(
        public readonly string $name,
        public readonly string $url,
        public readonly bool $matches,
    ) {
    }
}
