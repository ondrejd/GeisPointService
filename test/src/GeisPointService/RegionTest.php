<?php
/**
 * GeisPointService - Library implementing PHP client for GeisPoint web service.
 *
 * @author Ondrej Donek, <ondrejd@gmail.com>
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */

namespace GeisPointService;

/**
 * Tests for {@see \GeisPointService\Region}.
 */
class RegionTest extends \PHPUnit_Framework_TestCase
{
	public function testConstructorBlank()
	{
		$region = new Region();
		$this->assertInstanceOf('\GeisPointService\Region', $region);
		$this->assertEmpty($region->id_region);
		$this->assertEmpty($region->name);
	}

	public function testConstructorPartial()
	{
		$region = new Region(array('id_region' => Service::DEFAULT_REGION));
		$this->assertInstanceOf('\GeisPointService\Region', $region);
		$this->assertEquals(Service::DEFAULT_REGION, $region->id_region);
		$this->assertEmpty($region->name);
	}

	public function testConstructorFull()
	{
		$region = new Region(array(
			'id_region' => Service::DEFAULT_REGION,
			'name'      => 'Hl. m. Praha'.PHP_EOL
		));
		$this->assertInstanceOf('\GeisPointService\Region', $region);
		$this->assertEquals(Service::DEFAULT_REGION, $region->id_region);
		$this->assertEquals('Hl. m. Praha', $region->name);
	}
}
