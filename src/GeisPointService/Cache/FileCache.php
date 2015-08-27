<?php
/**
 * GeisPointService - Library implementing PHP client for GeisPoint web service.
 *
 * @author Ondřej Doněk, <ondrej.donek@ebrana.cz>
 * @license https://www.mozilla.org/MPL/2.0/ name
 */

namespace GeisPointService\Cache;

/**
 * Class that implementing file cache for `GeisPointService`.
 *
 * @author Ondřej Doněk, <ondrej.donek@ebrana.cz>
 */
class FileCache implements CacheInterface
{
	/**
	 * Path of the cache file.
	 *
	 * @var string $path
	 */
	protected $path;

	/**
	 * Cache data.
	 *
	 * @var \stdClass $data
	 */
	protected $data;

	/**
	 * Constructor.
	 *
	 * @param array $options (Optional.)
	 * @return void
	 */
	public function __construct($options = array())
	{
		if (!array_key_exists('path', $options)) {
			throw new Exception('The `path` key is missing in given options!');
		}

		$path = (string) $options['path'];

		if (empty($path)) {
			throw new Exception('Given path of cache file can not be empty!');
		}

		if (file_exists($path)) {
			if (!is_file($path) || !is_readable($path) || !is_writable($path)) {
				throw new Exception('Specified cache file is not a readable and writable file!');
			}
		} else {
			try {
				file_put_contents($path, serialize(new \stdClass()));
			} catch (\Exception $ex) {
				throw new Exception('Unable to create cache file with specified path!');
			}
		}

		// All `$path` tests are passed so read the cache
		$this->path = $path;
		$this->data = unserialize(file_get_contents($this->path));
	}

	/**
	 * Destructor.
	 *
	 * Writes data into the cache file.
	 *
	 * @return void
	 */
	public function __destruct()
	{
		file_put_contents($this->path, serialize($this->data));
	}

	/**
	 * Returns `TRUE` if value with given key exists in the cache.
	 *
	 * @param string $key
	 * @return boolean
	 */
	public function exists($key)
	{
		return isset($this->data->{$key});
	}

	/**
	 * Returns value for the given key.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get($key)
	{
		if (!$this->exists($key)) {
			return null;
		}

		return $this->data->{$key};
	}

	/**
	 * Adds new value into the cache.
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
	public function set($key, $value)
	{
		if (empty($key)) {
			throw new Exception('Key can not be empty!');
		}

		$this->data->{$key} = $value;
	}
}
