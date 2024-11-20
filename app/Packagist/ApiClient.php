<?php

declare(strict_types=1);

namespace App\Packagist;

use Packagist\Api\Client as BaseClient;
use Packagist\Api\Result\Package;
use Packagist\Api\Result\Result;
use Throwable;

use function array_filter;
use function is_array;

final readonly class ApiClient implements Client
{
    public function __construct(
        private BaseClient $client
    ) {}

    public function getPackage(string $packageName): ?Package
    {
        try {
            /** @var Package|Package[] $result */
            $result = $this->client->get($packageName);

            return is_array($result) ? $result[0] : $result;
        } catch (Throwable) {
            return null;
        }
    }

    public function search(string $name): array
    {
        try {
            /** @var Result[] $results */
            $results = $this->client->search($name, [], 2);

            return array_filter($results, fn (Result $result) => ! empty($result->getRepository()));
        } catch (Throwable) {
            return [];
        }
    }
}
