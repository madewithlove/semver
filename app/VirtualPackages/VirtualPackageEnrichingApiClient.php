<?php

declare(strict_types=1);

namespace App\VirtualPackages;

use App\Packagist\Client;
use Packagist\Api\Result\Package;

class VirtualPackageEnrichingApiClient implements Client
{
    /**
     * @var VirtualPackage[] $virtualPackages
     */
    public function __construct(
        private Client $client,
        private array $virtualPackages,
    ) {}

    public function getPackage(string $packageName): ?Package
    {
        foreach ($this->virtualPackages as $virtualPackage) {
            if ($virtualPackage->getName() === $packageName) {
                return $virtualPackage;
            }
        }

        return $this->client->getPackage($packageName);
    }

    public function search(string $name): array
    {
        return $this->client->search($name);
    }
}
