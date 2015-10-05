<?php
/**
 * GeisPointService - Library implementing PHP client for GeisPoint web service.
 *
 * @author Ondrej Donek, <ondrejd@gmail.com>
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */

namespace GeisPointService;

/**
 * Simple class describing region.
 *
 * @author Ondřej Doněk, <ondrej.donek@ebrana.cz>
 * @link http://www.geisparcel.cz/support/files/Geis_GeisPoint_WS.pdf
 */
class Region
{
	/**
	 * @var integer $id_region
	 */
	public $id_region;

	/**
	 * @var string $name
	 */
	public $name;

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

		if (is_string($data['name'])) {
			$this->name = trim((string) $data['name']);
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

		if (!array_key_exists('name', $data)) {
			$data['name'] = null;
		}

		return $data;
	}
}
