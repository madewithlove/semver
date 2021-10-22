<?php

declare(strict_types=1);

namespace App\Version;

final class Version
{
    public function __construct(
        private string $name,
        private string $url,
        private bool $matches,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function matches(): bool
    {
        return $this->matches;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
