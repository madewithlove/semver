<?php declare(strict_types=1);

namespace App\Packagist;

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
        // @todo add cache
        return $this->client->getPackage($packageName);
    }
}
