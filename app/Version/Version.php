<?php

declare(strict_types=1);

namespace App\Version;

use Illuminate\Support\Str;

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
        if (Str::startsWith($this->name, 'dev-')) {
            return substr($this->url, 0, -4) . '/tree/' . substr($this->name, 4);
        }

        return substr($this->url, 0, -4) . '/releases/tag/' . $this->name;
    }
}
