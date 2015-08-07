<?php

namespace Semver\Services\Packagist;

use Composer\Package\Version\VersionParser;
use Mockery;
use Packagist\Api\Result\Package\Source;
use Packagist\Api\Result\Package\Version;
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

	/**
	 * @return array
	 */
	private function buildVersions()
	{
		$source = new Source();
		$source->fromArray(['url' => 'http://lorem.ipsum']);

		$firstVersion = new Version();
		$firstVersion->fromArray([
			'source' => $source,
			'version' => '0.2.2'
		]);

		$secondVersion = new Version();
		$secondVersion->fromArray([
			'source' => $source,
			'version' => '0.2.1'
		]);

		return [
			'0.2.1' => $secondVersion,
			'0.2.2' => $firstVersion,
		];
	}

	/** @test */
	function it_gets_sorted_versions()
	{
		$vendor = 'madewithlove';
		$package = 'elasticsearcher';
		$packageName = "{$vendor}/{$package}";
		$versions = $this->buildVersions();

		$this->repository->shouldReceive('getVersions')
			->with($packageName)
			->andReturn($versions);

		$result = $this->service->getVersions('madewithlove', 'elasticsearcher');

		$this->assertCount(2, $result);
		$this->assertEquals($versions['0.2.2']->getVersion(), $result[0]['version']);
		$this->assertEquals($versions['0.2.1']->getVersion(), $result[1]['version']);
	}

	/** @test */
	function it_gets_matched_versions()
	{
		$vendor = 'madewithlove';
		$package = 'elasticsearcher';
		$packageName = "{$vendor}/{$package}";
		$versions = $this->buildVersions();

		$this->repository->shouldReceive('getVersions')
			->with($packageName)
			->andReturn($versions);

		$result = $this->service->getMatchingVersions($vendor, $package, '>=0.2.2');

		$this->assertCount(1, $result);
		$this->assertEquals('0.2.2', $result[0]);
	}
}
