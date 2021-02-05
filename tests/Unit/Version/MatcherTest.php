<?php declare(strict_types=1);

namespace Unit\Version;

use App\Version\Matcher;
use Composer\Semver\VersionParser;
use PHPUnit\Framework\TestCase;

final class MatcherTest extends TestCase
{
    private Matcher $matcher;

    protected function setUp(): void
    {
        $this->matcher = new Matcher(new VersionParser());
    }

    /** @test */
    public function it matches an exact same version(): void
    {
        $this->assertTrue($this->matcher->matches(
            '1.5.0',
            '1.5.0',
            'stable'
        ));
    }

    /**
     * @test
     * @dataProvider providesMatchingStableVersion
     */
    public function it matches an in bound version($version, $constraint): void
    {
        $this->assertTrue($this->matcher->matches('1.5.0', '^1.5', 'stable'));
    }

    public function providesMatchingStableVersion(): array
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
                '>1.5',
            ],
            [
                '1.5.0',
                '~1.5',
            ],
        ];
    }
}
