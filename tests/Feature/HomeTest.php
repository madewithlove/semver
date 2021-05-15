<?php declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class HomeTest extends TestCase
{
    /** @test */
    public function it can render the homepage(): void
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSeeTextInOrder([
                'Packagist Semver Checker',
                'madewithlove/htaccess-cli:dev-main',
                'Satisfied?',
                'composer require madewithlove/htaccess-cli:"dev-main"',
            ]);
    }
}
