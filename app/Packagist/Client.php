<?php declare(strict_types=1);

namespace App\Packagist;

use Packagist\Api\Result\Package;
use Packagist\Api\Result\Result;

interface Client
{
    public function getPackage(string $packageName): ?Package;

    /**
     * @return Result[]
     */
    public function search(string $name): array;
}
