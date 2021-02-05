<?php declare(strict_types=1);

namespace Unit\Version;

use App\Version\Matcher;
use PHPUnit\Framework\TestCase;

final class MatcherTest extends TestCase
{
    private Matcher $matcher;

    protected function setUp(): void
    {
        $this->matcher = new Matcher();
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
}
