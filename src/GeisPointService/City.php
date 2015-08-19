<?php
/**
 * GeisPointService - Library implementing PHP client for GeisPoint web service.
 *
 * @author Ondřej Doněk, <ondrej.donek@ebrana.cz>
 * @license https://www.mozilla.org/MPL/2.0/ name
 */

namespace GeisPointService;

/**
 * Simple class describing city with serving point.
 *
 * @author Ondřej Doněk, <ondrej.donek@ebrana.cz>
 */
class City
{
	/**
	 * @var integer $id_region
	 */
	public $id_region;

	/**
	 * @var string $city
	 */
	public $city;

	/**
	 * Constructor.
	 *
	 * @param integer $id_region (Optional.)
	 * @param string $city (Optional.)
	 * @return void
	 */
	public function __construct($id_region = null, $city = null)
	{
		if (!is_null($id_region) && !empty($id_region) && is_numeric($id_region)) {
			$this->id_region = intval($id_region);
		}

		if (!is_null($city) && !empty($city) && is_string($city)) {
			$this->city = trim($city);
		}
	}
}
