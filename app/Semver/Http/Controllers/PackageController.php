<?php
namespace Semver\Http\Controllers;

use Semver\Services\Packagist\Packagist;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
        $body = json_decode($this->request->getContent(), true);
        $constraint = isset($body['constraint']) ? $body['constraint'] : null;
        $minStability = isset($body['minimum-stability']) ? $body['minimum-stability'] : null;

        $versions = $this->packagist->getMatchingVersions($vendor, $package, $constraint, $minStability);

        return new JsonResponse($versions);
    }
}
