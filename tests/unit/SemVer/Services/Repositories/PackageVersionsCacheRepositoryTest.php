<?php

namespace Semver\Services\Repositories;

use Illuminate\Cache\NullStore;
use Illuminate\Cache\Repository;
use Mockery;
use PHPUnit_Framework_TestCase;
use Semver\Contracts\Repositories\PackageVersionsRepository;

class PackageVersionsCacheRepositoryTest extends PHPUnit_Framework_TestCase
{
	/** @var  PackageVersionsRepository|Mockery\Mock */
	private $innerRepository;

	/** @var  Repository|Mockery\Mock */
	private $cache;

	/** @var  PackageVersionsCacheRepository */
	private $repository;

	public function setUp()
	{
		$this->innerRepository = Mockery::mock(PackageVersionsRepository::class);
		$this->cache = Mockery::mock(Repository::class . '[get, put]', [new NullStore])->makePartial();
		$this->repository = new PackageVersionsCacheRepository($this->cache, $this->innerRepository);
	}

	public function tearDown()
	{
		Mockery::close();
	}

	/** @test */
	function it_calls_inner_repository_when_no_cache_exists()
	{
		$packageName = 'madewithlove/elasticsearcher';

		$this->cache->shouldReceive('get')
			->with($packageName)
			->once()
			->andReturn(null);

		$this->cache->shouldReceive('put')
			->with($packageName, 'lorem', 60)
			->once();

		$this->innerRepository->shouldReceive('getVersions')
			->with($packageName)
			->once()
			->andReturn('lorem');

		$this->assertEquals('lorem', $this->repository->getVersions($packageName));
	}

	/** @test */
	function it_gets_cached_result()
	{
		$packageName = 'madewithlove/elasticsearcher';

		$this->cache->shouldReceive('get')
			->with($packageName)
			->once()
			->andReturn('cached');

		$this->cache->shouldReceive('put')->never();
		$this->innerRepository->shouldReceive('getVersions')->never();

		$this->assertEquals('cached', $this->repository->getVersions($packageName));
	}
}
