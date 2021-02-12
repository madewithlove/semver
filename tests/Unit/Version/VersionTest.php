<?php declare(strict_types=1);

namespace Unit\Version;

use App\Version\Version;
use PHPUnit\Framework\TestCase;

final class VersionTest extends TestCase
{
    /** @test */
    public function it can generate a url to a tag(): void
    {
        $version = new Version(
            '8.27.0',
            'https://github.com/laravel/framework.git',
            true
        );

        $this->assertEquals(
            'https://github.com/laravel/framework/releases/tag/8.27.0',
            $version->getUrl()
        );
    }

    /** @test */
    public function it can generate a url to a dev branch(): void
    {
        $version = new Version(
            'dev-phpunit10',
            'https://github.com/laravel/framework.git',
            true
        );

        $this->assertEquals(
            'https://github.com/laravel/framework/tree/phpunit10',
            $version->getUrl()
        );
    }
}
