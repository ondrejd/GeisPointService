<?php
/**
 * GeisPointService - Library implementing PHP client for GeisPoint web service.
 *
 * @author Ondrej Donek, <ondrejd@gmail.com>
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */

namespace GeisPointService\Cache;

/**
 * Tests for {@see \GeisPointService\Service\Cache\DbCache}.
 */
class DbCacheTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Test cache with extended profile.
	 * @var \GeisPointService\Service\Cache\DbCache $simple
	 */
	protected $simpleSqlite;

	/**
	 * Test cache with extended profile.
	 * @var \GeisPointService\Service\Cache\DbCache $extended
	 */
	protected $extendedSqlite;

	/**
	 * Test cache with extended profile.
	 * @var \GeisPointService\Service\Cache\DbCache $simple
	 */
	protected $simpleMysql;

	/**
	 * Test cache with extended profile.
	 * @var \GeisPointService\Service\Cache\DbCache $extended
	 */
	protected $extendedMysql;

	public function setUp()
	{
		$path = dirname(dirname(dirname(__DIR__)));
		$this->simpleSqlite = new DbCache(array(
			'useCache' => true,
			'usedCache' => '\GeisPointService\Cache\DbCache',
			'cacheOptions' => array(
				'dsn' => "sqlite:{$path}\cache.sqlite",
			)
		));
		$this->extendedSqlite = new DbCache(array(
			'useCache' => true,
			'usedCache' => '\GeisPointService\Cache\DbCache',
			'cacheOptions' => array(
				'dsn' => "sqlite:{$path}\cache.sqlite",
				'schema' => DbCache::SCHEMA_TYPE_EXTENDED,
			)
		));
		$this->simpleMysql = new DbCache(array(
			'useCache' => true,
			'usedCache' => '\GeisPointService\Cache\DbCache',
			'cacheOptions' => array(
				'dsn' => 'mysql:host=localhost;dbname=GeisPointService;charset=utf8',
			)
		));
		$this->extendedMysql = new DbCache(array(
			'useCache' => true,
			'usedCache' => '\GeisPointService\Cache\DbCache',
			'cacheOptions' => array(
				'dsn' => 'mysql:host=localhost;dbname=GeisPointService;charset=utf8',
				'schema' => DbCache::SCHEMA_TYPE_EXTENDED,
			)
		));
	}

	public function testExists()
	{
		$this->markTestIncomplete();
	}

	public function testGet()
	{
		$this->markTestIncomplete();
	}

	public function testSet()
	{
		$this->markTestIncomplete();
	}
}