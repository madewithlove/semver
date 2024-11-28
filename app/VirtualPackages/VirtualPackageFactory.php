<?php

declare(strict_types=1);

namespace App\VirtualPackages;

final readonly class VirtualPackageFactory
{
    public static function php(): VirtualPackage
    {
        return new VirtualPackage(
            'php',
            [
                new VirtualPackageVersion('5.3', 'https://www.php.net/ChangeLog-5.php#PHP_5_3'),
                new VirtualPackageVersion('5.4', 'https://www.php.net/ChangeLog-5.php#PHP_5_4'),
                new VirtualPackageVersion('5.5', 'https://www.php.net/ChangeLog-5.php#PHP_5_5'),
                new VirtualPackageVersion('5.6', 'https://www.php.net/ChangeLog-5.php#PHP_5_6'),
                new VirtualPackageVersion('7.0', 'https://www.php.net/ChangeLog-7.php#PHP_7_0'),
                new VirtualPackageVersion('7.1', 'https://www.php.net/ChangeLog-7.php#PHP_7_1'),
                new VirtualPackageVersion('7.2', 'https://www.php.net/ChangeLog-7.php#PHP_7_2'),
                new VirtualPackageVersion('7.3', 'https://www.php.net/ChangeLog-7.php#PHP_7_3'),
                new VirtualPackageVersion('7.4', 'https://www.php.net/ChangeLog-7.php#PHP_7_4'),
                new VirtualPackageVersion('8.0', 'https://www.php.net/ChangeLog-8.php#PHP_8_0'),
                new VirtualPackageVersion('8.1', 'https://www.php.net/ChangeLog-8.php#PHP_8_1'),
                new VirtualPackageVersion('8.2', 'https://www.php.net/ChangeLog-8.php#PHP_8_2'),
                new VirtualPackageVersion('8.3', 'https://www.php.net/ChangeLog-8.php#PHP_8_3'),
                new VirtualPackageVersion('8.4', 'https://www.php.net/ChangeLog-8.php#PHP_8_4'),
            ]
        );
    }
}
