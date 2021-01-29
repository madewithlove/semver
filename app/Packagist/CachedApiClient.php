<?php declare(strict_types=1);

namespace App\Packagist;

use Illuminate\Support\Facades\Cache;
use Packagist\Api\Result\Package;

final class CachedApiClient implements Client
{
    private ApiClient $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function getPackage(string $packageName): ?Package
    {
        return Cache::remember('package-' . $packageName, 60 * 60, function () use ($packageName): ?Package {
            return $this->client->getPackage($packageName);
        });
    }
}
