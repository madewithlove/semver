<?php

namespace Semver\Services\Repositories;

use Mockery;
use Packagist\Api\Client;
use Packagist\Api\Result\Package;
use PHPUnit_Framework_TestCase;

class PackageVersionsRepositoryTest extends PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		Mockery::close();
	}

	/** @test */
	function it_calls_packagist_api()
	{
		$packagistClient = Mockery::mock(Client::class);
		$packages = Mockery::mock(Package::class);
		$repository = new PackageVersionsRepository($packagistClient);
		$packageName = 'madewithlove/elasticsearcher';

		$packages->shouldReceive('getVersions')
			->once()
			->andReturn('lorem');


		$packagistClient->shouldReceive('get')
			->with($packageName)
			->once()
			->andReturn($packages);

		$this->assertEquals('lorem', $repository->getVersions($packageName));
	}
}
