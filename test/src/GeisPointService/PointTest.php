<?php
/**
 * GeisPointService - Library implementing PHP client for GeisPoint web service.
 *
 * @author Ondřej Doněk, <ondrej.donek@ebrana.cz>
 * @license https://www.mozilla.org/MPL/2.0/ name
 */

namespace GeisPointService;

/**
 * Tests for {@see \GeisPointService\Point}.
 */
class PointTest extends \PHPUnit_Framework_TestCase
{
	public function testConstructorBlank()
	{
		$point = new Point();
		$this->assertInstanceOf('\GeisPointService\Point', $point);
		$this->assertEmpty($point->id_gp);
		$this->assertEmpty($point->id_region);
		$this->assertEmpty($point->name);
		$this->assertEmpty($point->city);
		$this->assertEmpty($point->street);
		$this->assertEmpty($point->zipcode);
		$this->assertEmpty($point->country);
		$this->assertEmpty($point->phone);
		$this->assertEmpty($point->openining_hours);
		$this->assertEmpty($point->holiday);
		$this->assertEmpty($point->map_url);
		$this->assertEmpty($point->gpsn);
		$this->assertEmpty($point->gpse);
		$this->assertEmpty($point->photo_url);
		$this->assertEmpty($point->note);
	}

	public function testConstructorPartial()
	{
		$point = new Point(array(
			'id_region' => 19,
			'city'      => 'Praha 5',
			'street'    => 'Jeremiášova 7',
			'zipcode'   => '15500',
			'country'   => 'ČR'
		));
		$this->assertInstanceOf('\GeisPointService\Point', $point);
		$this->assertEmpty($point->id_gp);
		$this->assertEquals(19, $point->id_region);
		$this->assertEmpty($point->name);
		$this->assertEquals('Praha 5', $point->city);
		$this->assertEquals('Jeremiášova 7', $point->street);
		$this->assertEquals('15500', $point->zipcode);
		$this->assertEquals('ČR', $point->country);
		$this->assertEmpty($point->phone);
		$this->assertEmpty($point->openining_hours);
		$this->assertEmpty($point->holiday);
		$this->assertEmpty($point->map_url);
		$this->assertEmpty($point->gpsn);
		$this->assertEmpty($point->gpse);
		$this->assertEmpty($point->photo_url);
		$this->assertEmpty($point->note);
	}

	public function testConstructorFull()
	{
		$point = new Point(array(
			'id_gp'           => 'VM-34002',
			'id_region'       => 19,
			'name'            => 'TABÁK VALMONT BILLA STODŮLKY',
			'city'            => 'Praha 5',
			'street'          => 'Jeremiášova 7',
			'zipcode'         => '15500',
			'country'         => 'ČR',
			'phone'           => '724 594 485',
			'openining_hours' => 'Po-So 7:00-13:00;13:30-18:00;18:30-20:30, So 8:00-13:00;13:30-18:00;18:30-20:30',
			'holiday'         => '',
			'map_url'         => 'http://mapy.cz/s/7RPJ',
			'gpsn'            => '50.04269083682189',
			'gpse'            => '14.314704325656166',
			'photo_url'       => 'http://data.e-shoppartner.cz/download/fotovydejny/58781280.jpg',
			'note'            => ''
		));
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
}
