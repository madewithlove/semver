<?php
namespace Semver\Unit\Stubs;

use Packagist\Api\Result\Package\Source;
use Packagist\Api\Result\Package\Version;

trait BuildVersions
{
    /**
     * @return array
     */
    private function buildVersions()
    {
        $source = new Source();
        $source->fromArray(['url' => 'http://lorem.ipsum']);

        $firstVersion = new Version();
        $firstVersion->fromArray([
            'source' => $source,
            'version' => '0.2.2',
        ]);

        $secondVersion = new Version();
        $secondVersion->fromArray([
            'source' => $source,
            'version' => '0.2.1',
        ]);

        return [
            $secondVersion,
            $firstVersion,
        ];
    }
}
