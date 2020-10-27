<?php

namespace Semver\Http\Controllers;

use Composer\Package\BasePackage;
use Psr\Http\Message\ServerRequestInterface;
use Semver\Services\Packagist\Packagist;
use UnexpectedValueException;
use Zend\Diactoros\Response\JsonResponse;

class PackageController
{
    /**
     * @var Packagist
     */
    private $packagist;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct(Packagist $packagist, ServerRequestInterface $request)
    {
        $this->packagist = $packagist;
        $this->request = $request;
    }

    /**
     * @param string $vendor
     * @param string $package
     *
     * @return JsonResponse
     */
    public function versions($vendor, $package)
    {
        // Hack to fix issue with phar in URI
        $package = $package == 'p-h-a-r' ? 'phar' : $package;

        $this->packagist->setMinimumStability('dev');

        $versions = $this->packagist->getVersions($vendor, $package);
        $defaultConstraint = $this->packagist->getDefaultConstraint($vendor, $package);

        return new JsonResponse(['default_constraint' => $defaultConstraint, 'versions' => $versions]);
    }

    /**
     * @param string $vendor
     * @param string $package
     *
     * @return JsonResponse
     */
    public function matchVersions($vendor, $package)
    {
        $this->configureMinimumStability();

        $queryParams = $this->request->getQueryParams();
        $constraint = isset($queryParams['constraint']) ? $queryParams['constraint'] : '*';
        $versions = $this->packagist->getMatchingVersions($vendor, $package, $constraint);

        return new JsonResponse($versions);
    }

    /**
     * Configured the minimum stability to be used when fetching versions.
     */
    protected function configureMinimumStability()
    {
        $queryParams = $this->request->getQueryParams();
        $minimumStability = isset($queryParams['minimum-stability']) ? $queryParams['minimum-stability'] : 'stable';
        if (!in_array($minimumStability, array_keys(BasePackage::$stabilities), true)) {
            throw new UnexpectedValueException(sprintf('Unsupported value for minimum-stability: %s', $minimumStability));
        }

        $this->packagist->setMinimumStability($minimumStability);
    }
}
