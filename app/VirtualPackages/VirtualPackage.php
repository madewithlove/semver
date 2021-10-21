<?php

declare(strict_types=1);

namespace App\VirtualPackages;

use Packagist\Api\Result\Package;

class VirtualPackage extends Package
{
    public function __construct(
        string $packageName,
        array $packageVersions
    ) {
        $this->name = $packageName;
        $this->versions = $packageVersions;
    }
}
