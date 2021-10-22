<?php declare(strict_types=1);

namespace App\Packagist;

use Packagist\Api\Result\Package;

interface Client
{
    public function getPackage(string $packageName): ?Package;

    public function search(string $name): array;
}
