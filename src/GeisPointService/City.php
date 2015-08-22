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
 * @link http://www.geisparcel.cz/support/files/Geis_GeisPoint_WS.pdf
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
	 * @param mixed $data
	 * @return void
	 */
	public function __construct($data = array())
	{
		if (is_object($data)) {
			$data = (array) $data;
		}

		$data = $this->normalizeData($data);

		if (/*!empty($data['id_region']) && */is_numeric($data['id_region'])) {
			$this->id_region = (int) $data['id_region'];
		}

		if (is_string($data['city'])) {
			$this->city = trim((string) $data['city']);
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
		if (!array_key_exists('id_region', $data)) {
			$data['id_region'] = null;
		}

		if (!array_key_exists('city', $data)) {
			$data['city'] = null;
		}

		return $data;
	}
}
