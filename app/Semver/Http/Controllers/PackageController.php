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
     * @var Packagist
     */
    private $packagist;

    /**
     * @param Packagist     $packagist
     * @param Request       $request
     */
    public function __construct(Packagist $packagist, Request $request)
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
        $constraint = $this->request->get('constraint', '*');
        $minimumStability = $this->request->get('minimum-stability', 'stable');

        if (!in_array($minimumStability, array_keys(BasePackage::$stabilities))) {
            throw new UnexpectedValueException(sprintf('Unsupported value for minimum-stability: %s', $minimumStability));
        }

        $versions = $this->packagist->getMatchingVersions($vendor, $package, $constraint, $minimumStability);

        return new JsonResponse($versions);
    }
}
