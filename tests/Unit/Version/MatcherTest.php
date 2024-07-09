<?php

declare(strict_types=1);

namespace Tests\Unit\Version;

use App\Version\Matcher;
use App\Version\Parser;
use Composer\Semver\VersionParser;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class MatcherTest extends TestCase
{
    private Matcher $matcher;

    protected function setUp(): void
    {
        $this->matcher = new Matcher(new Parser(new VersionParser()));
    }

    #[Test]
    public function it matches an exact same version(): void
    {
        $this->assertTrue($this->matcher->matches(
            '1.5.0',
            '1.5.0',
            'stable'
        ));
    }

    #[Test]
    #[DataProvider('providesMatchingStableVersion')]
    public function it matches an in bound version(string $version, string $constraint): void
    {
        $this->assertTrue($this->matcher->matches($version, $constraint, 'stable'));
    }

    /**
     * @return string[][]
     */
    public static function providesMatchingStableVersion(): array
    {
        return [
            [
                '1.5.0',
                '^1.5',
            ],
            [
                '1.5.0',
                '^1.4',
            ],
            [
                '1.5.0',
                '^1.0',
            ],
            [
                '1.5.0',
                '^1.5.0',
            ],
            [
                '1.5.0',
                '>=1.5',
            ],
            [
                '1.5.0',
                '>1.4',
            ],
            [
                '1.5.0',
                '~1.5',
            ],
        ];
    }

    #[Test]
    public function it does not match a version if the stability flag does not allow it(): void
    {
        $this->assertFalse($this->matcher->matches('dev-main', 'dev-main', 'stable'));
    }

    #[Test]
    public function it does not match an invalid constraint(): void
    {
        $this->assertFalse($this->matcher->matches('dev-main', 'NOT_A_CONSTRAINT', 'stable'));
    }
}
