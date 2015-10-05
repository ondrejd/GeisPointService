<?php
/**
 * GeisPointService - Library implementing PHP client for GeisPoint web service.
 *
 * @author Ondrej Donek, <ondrejd@gmail.com>
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */

namespace GeisPointService;

/**
 * Simple class describing single "GeisPoint".
 *
 * @author Ondřej Doněk, <ondrej.donek@ebrana.cz>
 * @link http://www.geisparcel.cz/support/files/Geis_GeisPoint_WS.pdf
 */
class Point
{
	/**
	 * @var string $id_gp
	 */
	public $id_gp;

	/**
	 * @var integer $id_region
	 */
	public $id_region;

	/**
	 * @var string $name
	 */
	public $name;

	/**
	 * @var string $city
	 */
	public $city;

	/**
	 * @var string $street
	 */
	public $street;

	/**
	 * @var string $zipcode
	 */
	public $zipcode;

	/**
	 * @var string $country
	 */
	public $country;

	/**
	 * @var string $email
	 */
	public $phone;

	/**
	 * @var string $openining_hours
	 */
	public $openining_hours;

	/**
	 * @var string $holiday
	 */
	public $holiday;

	/**
	 * @var string $map_url
	 */
	public $map_url;

	/**
	 * @var float $gpsn
	 */
	public $gpsn;

	/**
	 * @var float $gpse
	 */
	public $gpse;

	/**
	 * @var string $photo_url
	 */
	public $photo_url;

	/**
	 * @var string $note
	 */
	public $note;

	/**
	 * Constructor.
	 *
	 * @param mixed $data
	 * @return void
	 */
	public function __construct($data = array())
	{
		if (is_object($data)) {
			$data = (array) $data;
		}

		$data = $this->normalizeData($data);

		if (is_string($data['id_gp'])) {
			$this->id_gp = trim((string) $data['id_gp']);
		}

		if (/*!empty($data['id_region']) && */is_numeric($data['id_region'])) {
			$this->id_region = (int) $data['id_region'];
		}

		if (is_string($data['name'])) {
			$this->name = trim((string) $data['name']);
		}

		if (is_string($data['city'])) {
			$this->city = trim((string) $data['city']);
		}

		if (is_string($data['street'])) {
			$this->street = trim((string) $data['street']);
		}

		if (is_string($data['zipcode'])) {
			$this->zipcode = trim((string) $data['zipcode']);
		}

		if (is_string($data['country'])) {
			$this->country = trim((string) $data['country']);
		}

		if (is_string($data['phone'])) {
			$this->phone = trim((string) $data['phone']);
		}

		if (is_string($data['openining_hours'])) {
			$this->openining_hours = trim((string) $data['openining_hours']);
		}

		if (is_string($data['holiday'])) {
			$this->holiday = trim((string) $data['holiday']);
		}

		if (is_string($data['map_url'])) {
			$this->map_url = trim((string) $data['map_url']);
		}

		if (is_string($data['gpsn'])) {
			$this->gpsn = trim((string) $data['gpsn']);
		}

		if (is_string($data['gpse'])) {
			$this->gpse = trim((string) $data['gpse']);
		}

		if (is_string($data['photo_url'])) {
			$this->photo_url = trim((string) $data['photo_url']);
		}

		if (is_string($data['note'])) {
			$this->note = trim((string) $data['note']);
		}
	}

	/**
	 * Normalizes input data array.
	 *
	 * @param array $data
	 * @return array
	 */
	protected function normalizeData($data = array())
	{
		if (!array_key_exists('id_gp', $data)) {
			$data['id_gp'] = null;
		}

		if (!array_key_exists('id_region', $data)) {
			$data['id_region'] = null;
		}

		if (!array_key_exists('name', $data)) {
			$data['name'] = null;
		}

		if (!array_key_exists('city', $data)) {
			$data['city'] = null;
		}

		if (!array_key_exists('street', $data)) {
			$data['street'] = null;
		}

		if (!array_key_exists('zipcode', $data)) {
			$data['zipcode'] = null;
		}

		if (!array_key_exists('country', $data)) {
			$data['country'] = null;
		}

		if (!array_key_exists('phone', $data)) {
			$data['phone'] = null;
		}

		if (!array_key_exists('openining_hours', $data)) {
			$data['openining_hours'] = null;
		}

		if (!array_key_exists('holiday', $data)) {
			$data['holiday'] = null;
		}

		if (!array_key_exists('map_url', $data)) {
			$data['map_url'] = null;
		}

		if (!array_key_exists('gpsn', $data)) {
			$data['gpsn'] = null;
		}

		if (!array_key_exists('gpse', $data)) {
			$data['gpse'] = null;
		}

		if (!array_key_exists('photo_url', $data)) {
			$data['photo_url'] = null;
		}

		if (!array_key_exists('note', $data)) {
			$data['note'] = null;
		}

		return $data;
	}
}
