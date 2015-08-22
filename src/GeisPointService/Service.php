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
 * @link http://www.geisparcel.cz/support/files/Geis_GeisPoint_WS.pdf
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
		if (array_key_exists('cache', $options)) {
			// ...
		}

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
	 * @param string $country (Optional.)
	 * @return array
	 * @todo Add cache!
	 */
	public function getRegions($country = null)
	{
		$country = (is_null($country) || empty($country))
			? $this->defaultCountry
			: $country;

		$arguments = array('country_code' => $country);

		$json = $this->client->__soapCall('getRegions', $arguments);
		$data = json_decode($json);
		$ret = array();

		foreach ($data as $itm) {
			if (is_object($itm)) {
				$ret[] = new Region($itm);
			}
		}

		return $ret;
	}

	/**
	 * Retrieve cities for the specified region.
	 *
	 * @param string $country (Optional.)
	 * @param integer $region (Optional.)
	 * @return array
	 */
	public function getCities($country = null, $region = null)
	{
		$country = (is_null($country) || empty($country))
			? $this->defaultCountry
			: $country;

		$region = (is_null($region) || empty($region))
			? $this->defaultRegion
			: $region;

		$arguments = array('country_code' => $country, 'id_region' => $region);

		$json = $this->client->__soapCall('getCities', $arguments);
		$data = json_decode($json);
		$ret = array();

		foreach ($data as $itm) {
			if (is_object($itm)) {
				$ret[] = new City($itm);
			}
		}

		return $ret;
	}

	/**
	 * Returns detail informations about single Geis Point.
	 *
	 * @param string $gpid
	 * @return \GeisPointService\Point
	 * @throws \InvalidArgumentException
	 */
	public function getPointDetail($gpid)
	{
		if (!is_string($gpid)) {
			throw new \InvalidArgumentException();
		}

		if (empty($gpid)) {
			throw new \InvalidArgumentException();
		}

		$arguments = array('id_gp' => (string) $gpid);
		$json = $this->client->__soapCall('getGPDetail', $arguments);
		$data = json_decode($json);

		if (count($data) === 1) {
			return new Point($data[0]);
		}

		throw new Exception('GeisPoint details was not found!');
	}

	/**
	 * Performs search for Geis Points. At least one parameter MUST be passed.
	 *
	 * @param string $zip
	 * @param string $city
	 * @param string $gpid
	 * @return array
	 * @throws \InvalidArgumentException
	 */
	public function searchPoints($zip, $city, $gpid)
	{
		$arguments = array();

		if (!empty($zip)) {
			$arguments['zip'] = $zip;
		}

		if (!empty($city)) {
			$arguments['city'] = $city;
		}

		if (!empty($gpid)) {
			$arguments['id_gp'] = $gpid;
		}

		if (count($arguments) === 0) {
			throw new \InvalidArgumentException();
		}

		$arguments = array_merge(
			array('zip' => '', 'city' => '', 'id_gp' => ''),
			$arguments
		);

		$json = $this->client->__soapCall('searchGP', $arguments);
		$data = json_decode($json);
		$ret = array();

		foreach ($data as $itm) {
			if (is_object($itm)) {
				$ret[] = new Point($itm);
			}
		}

		return $ret;
	}
}
