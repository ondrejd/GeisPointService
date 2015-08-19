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
 *
 * @author Ondřej Doněk, <ondrej.donek@ebrana.cz>
 */
class Service implements ServiceInterface
{
	/**
	 * @const string URL webove sluzby.
	 */
	const URL = 'http://plugin.geispoint.cz/wsdl/wsdl.php?WSDL';

	/**
	 * @const string Defaultni zeme (Ceska Republika).
	 */
	const DEFAULT_COUNTRY = 'CZ';

	/**
	 * @const string Defaultni region (Praha)
	 */
	const DEFAULT_REGION = 19;

	/**
	 * @var string $defaultCountry
	 */
	protected $defaultCountry;

	/**
	 * @var string $defaultRegion
	 */
	protected $defaultRegion;

	/**
	 * @var string|null $lastError
	 */
	protected $lastError;

	/**
	 * @var SoapClient $client
	 */
	protected $client;

	/**
	 * @var array $cache
	 */
	protected $cache;

	/**
	 * Konstruktor.
	 *
	 * @param array $options
	 * @return void
	 */
	public function __construct($options = array())
	{
		$this->defaultCountry = (isset($options['defaultCountry']))
				? $options['defaultCountry']
				: self::DEFAULT_COUNTRY;

		$this->defaultRegion = (isset($options['defaultRegion']))
				? $options['defaultCity']
				: self::DEFAULT_REGION;

		// TODO Cache!

		$this->client = new \SoapClient(self::URL);
	}

	/**
	 * Vrati posledni chybu.
	 *
	 * @return string|null
	 */
	public function getLastError()
	{
		return $this->lastError;
	}

	/**
	 * Retrieve regions.
	 *
	 * @param string $countryCode
	 * @return array
	 * @todo Add cache!
	 */
	public function getRegions($countryCode = null)
	{
		$code = (is_null($countryCode) || empty($countryCode))
			? $this->defaultCountry
			: $countryCode;

		$arguments = array('country_code' => $code);

		$json = $this->client->__soapCall('getRegions', $arguments);
		$arr = json_decode($json);
		$ret = array();

		foreach ($arr as $itm) {
			if (!is_object($itm)) continue;
			if (!isset($itm->id_region) || !isset($itm->name)) continue;

			$id = $itm->id_region;
			$ret[$id] = new \GeisPointService\Region($id, $itm->name);
		}

		return $ret;
	}

	/**
	 * Retrieve cities for the specified region.
	 *
	 * @param string $countryCode
	 * @param integer $regionId
	 * @return array
	 */
	public function getCities($countryCode = null, $regionId = null)
	{
		$code = (is_null($countryCode) || empty($countryCode))
			? $this->defaultCountry
			: $countryCode;

		$region = (is_null($regionId) || empty($regionId))
			? $this->defaultRegion
			: $regionId;

		$arguments = array('country_code' => $code, 'id_region' => $region);

		$json = $this->client->__soapCall('getRegions', $arguments);
		$arr = json_decode($json);
		$ret = array();

		foreach ($arr as $itm) {
			if (!is_object($itm)) continue;
			if (!isset($itm->id_region) || !isset($itm->city)) continue;

			$ret[$id] = new \GeisPointService\City($itm->id_region, $itm->city);
		}

		return $ret;
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
