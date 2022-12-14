<?php

declare(strict_types=1);

namespace App\Version;

final readonly class Version
{
    public function __construct(
        public string $name,
        public string $url,
        public bool $matches,
    ) {
    }
}
