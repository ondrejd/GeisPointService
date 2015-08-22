<?php
/**
 * GeisPointService - Library implementing PHP client for GeisPoint web service.
 *
 * @author Ondřej Doněk, <ondrej.donek@ebrana.cz>
 * @license https://www.mozilla.org/MPL/2.0/ name
 */

namespace GeisPointService;

/**
 * Tests for {@see \GeisPointService\City}.
 */
class CityTest extends \PHPUnit_Framework_TestCase
{
	public function testConstructorBlank()
	{
		$city = new City();
		$this->assertInstanceOf('\GeisPointService\City', $city);
		$this->assertEmpty($city->id_region);
		$this->assertEmpty($city->city);
	}

	public function testConstructorPartial()
	{
		$city = new City(array('id_region' => Service::DEFAULT_REGION));
		$this->assertInstanceOf('\GeisPointService\City', $city);
		$this->assertEquals(Service::DEFAULT_REGION, $city->id_region);
		$this->assertEmpty($city->city);
	}

	public function testConstructorFull()
	{
		$city = new City(array(
			'id_region' => Service::DEFAULT_REGION,
			'city'      => 'Praha 1'
		));
		$this->assertInstanceOf('\GeisPointService\City', $city);
		$this->assertEquals(Service::DEFAULT_REGION, $city->id_region);
		$this->assertEquals('Praha 1', $city->city);
	}
}
