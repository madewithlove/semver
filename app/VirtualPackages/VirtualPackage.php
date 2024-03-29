<?php

declare(strict_types=1);

namespace App\VirtualPackages;

use Packagist\Api\Result\Package;

final class VirtualPackage extends Package
{
    /**
     * @param  VirtualPackageVersion[]  $packageVersions
     */
    public function __construct(
        string $packageName,
        array $packageVersions
    ) {
        $this->name = $packageName;
        $this->versions = $packageVersions;
    }
}
