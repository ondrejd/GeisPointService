<?php
/**
 * GeisPointService - Library implementing PHP client for GeisPoint web service.
 *
 * @author Ondrej Donek, <ondrejd@gmail.com>
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */

namespace GeisPointService;

/**
 * Tests for {@see \GeisPointService\Service}.
 */
class ServiceTest extends \PHPUnit_Framework_TestCase
{
	/** @var Service */
	protected $gpsrv;

	public function setUp()
	{
		$this->gpsrv = new Service();
	}

	public function testGetRegions()
	{
		$regions = $this->gpsrv->getRegions(Service::DEFAULT_COUNTRY);
		$this->assertEquals(14, count($regions));

		// Select random region
		$region = $regions[rand(0, count($regions) - 1)];
		$this->assertInstanceOf('\GeisPointService\Region', $region);
	}

	public function testGetCities()
	{
		$regions = $this->gpsrv->getRegions(Service::DEFAULT_COUNTRY);
		$this->assertEquals(14, count($regions));

		// Select random region
		$region = $regions[rand(0, count($regions) - 1)];
		$this->assertInstanceOf('\GeisPointService\Region', $region);

		// Vybereme města zvoleného regionu
		$cities = $this->gpsrv->getCities(Service::DEFAULT_COUNTRY, 19);
		$this->assertEquals(11, count($cities));

		// Vybereme náhodné město
		$city = $cities[rand(0, count($cities) - 1)];
		$this->assertInstanceOf('\GeisPointService\City', $city);
	}

	public function testGetPointDetail()
	{
		$point = $this->gpsrv->getPointDetail('VM-34002');

		$this->assertInstanceOf('\GeisPointService\Point', $point);
		$this->assertEquals('VM-34002', $point->id_gp);
		$this->assertEquals(19, $point->id_region);
		$this->assertEquals('TABÁK VALMONT BILLA STODŮLKY', $point->name);
		$this->assertEquals('Praha 5', $point->city);
		$this->assertEquals('Jeremiášova 7', $point->street);
		$this->assertEquals('15500', $point->zipcode);
		$this->assertEquals('ČR', $point->country);
		$this->assertEquals('724 594 485', $point->phone);
		$this->assertEquals('Po-So 7:00-13:00;13:30-18:00;18:30-20:30, So 8:00-13:00;13:30-18:00;18:30-20:30', $point->openining_hours);
		$this->assertEmpty($point->holiday);
		$this->assertEquals('http://mapy.cz/s/7RPJ', $point->map_url);
		$this->assertEquals('50.04269083682189', $point->gpsn);
		$this->assertEquals('14.314704325656166', $point->gpse);
		$this->assertEquals('http://data.e-shoppartner.cz/download/fotovydejny/58781280.jpg', $point->photo_url);
		$this->assertEmpty($point->note);
	}

	public function testSearchPoints()
	{
		// The first test search
		$search1 = $this->gpsrv->searchPoints('15500', null, null);
		$this->assertEquals(2, count($search1));

		// Select random Geis Point
		$point1 = $search1[rand(0, count($search1) - 1)];
		$this->assertInstanceOf('\GeisPointService\Point', $point1);

		// The second test search
		$search2 = $this->gpsrv->searchPoints(null, 'Praha 5', null);
		$this->assertEquals(4, count($search2));

		// Select random Geis Point
		$point2 = $search2[rand(0, count($search2) - 1)];
		$this->assertInstanceOf('\GeisPointService\Point', $point2);
	}
}
