<?php declare(strict_types=1);

namespace App\Packagist;

use Packagist\Api\Client as BaseClient;
use Packagist\Api\Result\Package;
use Throwable;

final class ApiClient implements Client
{
    public function __construct(
        private BaseClient $client
    ) {}

    public function getPackage(string $packageName): ?Package
    {
        try {
            $result = $this->client->get($packageName);
            if (is_array($result)) {
                return $result[0];
            }
            return $result;
        } catch (Throwable) {
            return null;
        }
    }

    public function search(string $name): array
    {
        try {
            return $this->client->search($name, [], 2);
        } catch (Throwable) {
            return [];
        }
    }
}
