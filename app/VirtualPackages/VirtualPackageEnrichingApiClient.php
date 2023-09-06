<?php

declare(strict_types=1);

namespace App\VirtualPackages;

use App\Packagist\Client;
use Packagist\Api\Result\Package;

class VirtualPackageEnrichingApiClient implements Client
{
    /**
     * @param  VirtualPackage[]  $virtualPackages
     */
    public function __construct(
        private Client $client,
        private array $virtualPackages,
    ) {
    }

    public function getPackage(string $packageName): ?Package
    {
        foreach ($this->virtualPackages as $virtualPackage) {
            if ($packageName === $virtualPackage->getName()) {
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
