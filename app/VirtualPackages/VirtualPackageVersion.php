<?php

declare(strict_types=1);

namespace App\VirtualPackages;

use Packagist\Api\Result\Package\Version;

class VirtualPackageVersion extends Version
{
    public function __construct(
        protected string $version,
        private string $url
    ) {
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getVersionNormalized(): string
    {
        return $this->getVersion();
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
