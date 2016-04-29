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

    /**
     * @param Packagist              $packagist
     * @param ServerRequestInterface $request
     */
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

        $constraint = $this->request->getAttribute('constraint', '*');
        $versions = $this->packagist->getMatchingVersions($vendor, $package, $constraint);

        return new JsonResponse($versions);
    }

    /**
     * Configured the minimum stability to be used when fetching versions.
     */
    protected function configureMinimumStability()
    {
        $minimumStability = $this->request->getAttribute('minimum-stability', 'stable');
        if (!in_array($minimumStability, array_keys(BasePackage::$stabilities), true)) {
            throw new UnexpectedValueException(sprintf('Unsupported value for minimum-stability: %s', $minimumStability));
        }

        $this->packagist->setMinimumStability($minimumStability);
    }
}
