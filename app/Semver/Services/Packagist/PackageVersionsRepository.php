<?php

namespace Semver\Services\Packagist;

use Packagist\Api\Result\Package\Version;

interface PackageVersionsRepository
{
	/**
	 * @param string $package vendor/package
	 * @return Version[]
	 */
	public function getVersions($package);
}