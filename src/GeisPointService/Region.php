<?php
/**
 * GeisPointService - Library implementing PHP client for GeisPoint web service.
 *
 * @author Ondřej Doněk, <ondrej.donek@ebrana.cz>
 * @license https://www.mozilla.org/MPL/2.0/ name
 */

namespace GeisPointService;

/**
 * Simple class describing region.
 *
 * @author Ondřej Doněk, <ondrej.donek@ebrana.cz>
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
	 * @param integer $id_region (Optional.)
	 * @param string $name (Optional.)
	 * @return void
	 */
	public function __construct($id_region = null, $name = null)
	{
		if (!is_null($id_region) && !empty($id_region) && is_numeric($id_region)) {
			$this->id_region = intval($id_region);
		}

		if (!is_null($name) && !empty($name) && is_string($name)) {
			$this->name = trim($name);
		}
	}
}
