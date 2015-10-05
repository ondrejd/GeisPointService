<?php
/**
 * GeisPointService - Library implementing PHP client for GeisPoint web service.
 *
 * @author Ondrej Donek, <ondrejd@gmail.com>
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */

namespace GeisPointClient;

/**
 * Abstract class for GeisPoint service clients.
 *
 * @author Ondřej Doněk, <ondrej.donek@ebrana.cz>
 */
abstract class AbstractClient
{
	/**
	 * Client options.
	 *
	 * @param array $options
	 */
	protected $options;

	/**
	 * Constructor.
	 *
	 * @param array $options
	 * @return void
	 */
	public function __construct($options = array())
	{
		$this->options = $this->normalizeOptions($options);

		// ...
	}

	/**
	 * Normalizes array with service options.
	 *
	 * @param array $options
	 * @return array
	 */
	protected function normalizeOptions(array $options)
	{
		if (!array_key_exists('useCache', $options)) {
			$options['useCache'] = false;
		}

		// ...

		return $options;
	}

	/**
	 * Retrieve client options.
	 *
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}

	/**
	 * Select regions.
	 *
	 * @return void
	 */
	abstract public function selectRegionsAction();

	/**
	 * Select cities.
	 *
	 * @return void
	 */
	abstract public function selectCitiesAction();

	/**
	 * Search GeisPoint offices.
	 *
	 * @return void
	 */
	abstract public function searchPointsAction();

	/**
	 * Retrieve details about GeisPoint office.
	 *
	 * @return void
	 */
	abstract public function getPointDetailsAction();
}
