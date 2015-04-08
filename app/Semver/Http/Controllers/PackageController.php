<?php
namespace Semver\Http\Controllers;

use Composer\Package\BasePackage;
use Semver\Services\Packagist\Packagist;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UnexpectedValueException;

class PackageController
{
    /**
     * @type Request
     */
    private $request;

    /**
     * @type Packagist
     */
    private $packagist;

    /**
     * @param Packagist $packagist
     * @param Request   $request
     */
    public function __construct(Packagist $packagist, Request $request)
    {
        $this->packagist = $packagist;
        $this->request   = $request;
    }

    /**
     * @param string $vendor
     * @param string $package
     *
     * @return JsonResponse
     */
    public function versions($vendor, $package)
    {
        $this->configureMinimumStability();

        $versions          = $this->packagist->getVersions($vendor, $package);
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

        $constraint = $this->request->get('constraint', '*');
        $versions   = $this->packagist->getMatchingVersions($vendor, $package, $constraint);

        return new JsonResponse($versions);
    }

    /**
     * Configured the minimum stability to be used when fetching versions
     */
    protected function configureMinimumStability()
    {
        $minimumStability = $this->request->get('minimum-stability', 'stable');
        if (!in_array($minimumStability, array_keys(BasePackage::$stabilities), true)) {
            throw new UnexpectedValueException(sprintf('Unsupported value for minimum-stability: %s', $minimumStability));
        }

        $this->packagist->setMinimumStability($minimumStability);
    }
}
