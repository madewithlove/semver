<?php

declare(strict_types=1);

namespace App\Packagist;

use Illuminate\Support\Facades\Cache;
use Packagist\Api\Result\Package;

final readonly class CachedApiClient implements Client
{
    public function __construct(
        private ApiClient $client
    ) {}

    public function getPackage(string $packageName): ?Package
    {
        /** @phpstan-ignore-next-line */
        return Cache::remember('package-' . $packageName, 60 * 60, function () use ($packageName): ?Package {
            return $this->client->getPackage($packageName);
        });
    }

    public function search(string $name): array
    {
        /** @phpstan-ignore-next-line */
        return Cache::remember('search-' . $name, 60 * 60, function () use ($name): array {
            return $this->client->search($name);
        });
    }
}
