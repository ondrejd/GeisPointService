<?php
/**
 * GeisPointService - Library implementing PHP client for GeisPoint web service.
 *
 * @author Ondřej Doněk, <ondrej.donek@ebrana.cz>
 * @license https://www.mozilla.org/MPL/2.0/ name
 */

namespace GeisPointService;

/**
 * Class that implements client of GeisPoint service.
 */
class Service implements ServiceInterface
{
	/**
	 * Retrieve regions.
	 *
	 * @param string $countryCode
	 * @return array
	 */
	public function getRegions($countryCode)
	{
		// ...
	}

	/**
	 * Retrieve cities for the specified region.
	 *
	 * @param string $countryCode
	 * @param integer $regionId
	 * @return array
	 */
	public function getCities($countryCode, $regionId)
	{
		// ...
	}

	/**
	 * Returns detail informations about single Geis Point.
	 *
	 * @param string $gpId
	 * @return array
	 */
	public function getPointDetail($gpId)
	{
		// ...
	}

	/**
	 * Performs search for Geis Points. At least one parameter MUST be passed.
	 *
	 * @param string $zip
	 * @param string $city
	 * @param string $gpId
	 * @return array
	 */
	public function searchPoints($zip, $city, $gpId)
	{
		// ...
	}
}
