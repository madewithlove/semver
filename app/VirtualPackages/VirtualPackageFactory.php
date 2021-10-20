<?php

declare(strict_types=1);

namespace App\VirtualPackages;

class VirtualPackageFactory
{
    public static function php(): VirtualPackage {
        return new VirtualPackage(
            'php',
            [
                new VirtualPackageVersion('6.5'),
                new VirtualPackageVersion('7.0'),
                new VirtualPackageVersion('7.1'),
                new VirtualPackageVersion('7.2'),
                new VirtualPackageVersion('7.3'),
                new VirtualPackageVersion('7.4'),
                new VirtualPackageVersion('8.0'),
                new VirtualPackageVersion('8.1'),
            ]
        );
    }
}
