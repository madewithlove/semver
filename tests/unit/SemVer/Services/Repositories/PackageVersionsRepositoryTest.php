<?php
namespace Semver\Unit\Services\Repositories;

use Mockery;
use Packagist\Api\Client;
use Packagist\Api\Result\Package;
use PHPUnit_Framework_TestCase;
use Semver\Services\Repositories\PackageVersionsRepository;
use Semver\Unit\Stubs\BuildVersions;

class PackageVersionsRepositoryTest extends PHPUnit_Framework_TestCase
{
    use BuildVersions;

    /**
     * Tear down.
     */
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function it_calls_packagist_api()
    {
        // Arrange
        $packagistClient = Mockery::mock(Client::class);
        $packages = Mockery::mock(Package::class);
        $repository = new PackageVersionsRepository($packagistClient);
        $packageName = 'madewithlove/elasticsearcher';

        $packages->shouldReceive('getVersions')
            ->once()
            ->andReturn($this->buildVersions());

        $packagistClient->shouldReceive('get')
            ->with($packageName)
            ->once()
            ->andReturn($packages);

        // Act
        $result = $repository->getVersions($packageName);

        // Assert
        $this->assertCount(2, $result);
        $this->assertEquals('0.2.2', $result[0]->getVersion());
        $this->assertEquals('0.2.1', $result[1]->getVersion());
    }
}
