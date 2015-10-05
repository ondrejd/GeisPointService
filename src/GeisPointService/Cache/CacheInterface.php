<?php
/**
 * GeisPointService - Library implementing PHP client for GeisPoint web service.
 *
 * @author Ondrej Donek, <ondrejd@gmail.com>
 * @license https://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */

namespace GeisPointService\Cache;

/**
 * Interface for classes implementing cache for `GeisPointService`.
 *
 * @author Ondřej Doněk, <ondrej.donek@ebrana.cz>
 */
interface CacheInterface
{
	/**
	 * Returns `TRUE` if value with given key exists in the cache.
	 *
	 * @param string $key
	 * @return boolean
	 */
	public function exists($key);

	/**
	 * Returns value for the given key.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get($key);

	/**
	 * Adds new value into the cache.
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
	public function set($key, $value);
}
