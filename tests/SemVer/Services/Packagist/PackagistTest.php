<?php

namespace Semver\Services\Packagist;

use Composer\Package\Version\VersionParser;
use Illuminate\Cache\Repository;
use Mockery;
use Packagist\Api\Client;
use PHPUnit_Framework_TestCase;

class PackagistTest extends PHPUnit_Framework_TestCase
{
	/** @var  Client|Mockery\Mock */
	private $client;

	/** @var  Repository|Mockery\Mock */
	private $cache;

	/** @var  Packagist */
	private $service;

	public function setUp()
	{
		$this->client = Mockery::mock(Client::class);
		$this->cache = Mockery::mock(Repository::class);

		$this->service = new Packagist(
			$this->client,
			new VersionParser(),
			$this->cache
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
