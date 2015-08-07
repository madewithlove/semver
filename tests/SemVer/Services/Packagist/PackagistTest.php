<?php

namespace Semver\Services\Packagist;

use Composer\Package\Version\VersionParser;
use Mockery;
use PHPUnit_Framework_TestCase;

class PackagistTest extends PHPUnit_Framework_TestCase
{
	/** @var  PackageVersionsRepository|Mockery\Mock */
	private $repository;

	/** @var  Packagist */
	private $service;

	public function setUp()
	{
		$this->repository = Mockery::mock(PackageVersionsRepository::class);

		$this->service = new Packagist(
			new VersionParser(),
			$this->repository
		);
	}

	public function tearDown()
	{
		Mockery::close();
	}

	/** @test */
	function it_works()
	{
		$this->assertInstanceOf(Packagist::class, $this->service);
	}
}
