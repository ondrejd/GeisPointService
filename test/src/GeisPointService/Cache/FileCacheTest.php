<?php
/**
 * GeisPointService - Library implementing PHP client for GeisPoint web service.
 *
 * @author Ondřej Doněk, <ondrej.donek@ebrana.cz>
 * @license https://www.mozilla.org/MPL/2.0/ name
 */

namespace GeisPointService\Cache;

/**
 * Tests for {@see \GeisPointService\Service\Cache\FileCache}.
 */
class FileCacheTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Test cache with extended profile.
	 * @var \GeisPointService\Service\Cache\FileCache $simple
	 */
	protected $simple;

	public function setUp()
	{
		$this->simple = new FileCache(array(
			'path' => '/home/ondrejd/GitHub/GeisPointService/test/cache.tmp',
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