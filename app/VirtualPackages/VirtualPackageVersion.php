<?php

declare(strict_types=1);

namespace App\VirtualPackages;

use Packagist\Api\Result\Package\Version;

final class VirtualPackageVersion extends Version
{
    public function __construct(
        protected string $version,
        public readonly string $url
    ) {}

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getVersionNormalized(): string
    {
        return $this->getVersion();
    }
}
