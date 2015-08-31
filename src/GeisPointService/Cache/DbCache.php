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
class DbCache implements CacheInterface
{
	/**
	 * Default DSN.
	 * @const string
	 */
	const DEFAULT_DSN = 'sqlite:cache.sqlite';

	/**
	 * Schema type simple.
	 * @const string
	 */
	const SCHEMA_TYPE_SIMPLE = 'simple';

	/**
	 * Schema type extended.
	 * @const string
	 */
	const SCHEMA_TYPE_EXTENDED = 'extended';

	/**
	 * @var array $options Given options.
	 */
	protected $options;

	/**
	 * Database connection
	 *
	 * @var \PDO $pdo
	 */
	protected $pdo;

	/**
	 * Constructor.
	 *
	 * @param array $options (Optional.)
	 * @return void
	 */
	public function __construct($options = array())
	{
		$this->options = $this->normalizeOptions($options);

		// 1) initialize database using PDO
		try {
			$this->pdo = new \PDO(
				$this->options['dsn'],
				$this->options['user'],
				$this->options['password']
			);
		} catch (\PDOException $ex) {
			throw new Exception('Unable to connect database with given options!');
		}

		// 2) according to used schema type initialize tables
		$this->initSchema();
	}

	/**
	 * Normalizes given class options.
	 *
	 * @param array $options
	 * @return array
	 */
	protected function normalizeOptions(array $options)
	{

		// dsn|user|password|prefix|schema
		if (!array_key_exists('dsn', $options)) {
			// If no DSN is defined we used simple SQLite cache.
			$options['dsn'] = self::DEFAULT_DSN;
		}
		else if (empty($options['dsn']) || !is_string($options['dsn'])) {
			$options['dsn'] = self::DEFAULT_DSN;
		}

		if (!array_key_exists('user', $options)) {
			$options['user'] = null;
		}

		if (!array_key_exists('password', $options)) {
			$options['password'] = null;
		}

		if (!array_key_exists('prefix', $options)) {
			$options['prefix'] = '';
		}

		if (!array_key_exists('schema', $options)) {
			$options['schema'] = self::SCHEMA_TYPE_SIMPLE;
		}

		if (!in_array(
			$options['schema'],
			array(self::SCHEMA_TYPE_SIMPLE, self::SCHEMA_TYPE_EXTENDED)
		)) {
			throw new Exception('Given cache schema type is not valid!');
		}

		return $options;
	}

	/**
	 * Checks if database tables are created or not and if it's neccessary
	 * creates them.
	 *
	 * @return void
	 * @throws Exception Whenever something goes wrong.
	 */
	protected function initSchema()
	{
		$method = 
			'init' .
			($this->isSimple() ? 'Simple' : 'Extended') .
			($this->isSqlite() ? 'Sqlite' : 'Sql') .
			'Schema';

		call_user_func(array($this, $method));
	}

	/**
	 * @internal Private method used for creation extended schema for SQLite database.
	 * @return void
	 * @throws Exception Whenever extecuted SQL query failed.
	 */
	private function initExtendedSqliteSchema()
	{
		$prefix = (string) $this->options['prefix'];
		$sql = <<<EOT
CREATE TABLE IF NOT EXISTS `{$prefix}region` (
	`id_region` INTEGER PRIMARY KEY AUTOINCREMENT,
	`country` VARCHAR(5) NOT NULL,
	`name` VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `{$prefix}city` (
	`id_region` INTEGER NOT NULL REFERENCES `{$prefix}region`  (`id_region`),
	`city` VARCHAR(255)  PRIMARY KEY NOT NULL
);

CREATE TABLE IF NOT EXISTS `{$prefix}point` (
	`id_gp` VARCHAR(11) PRIMARY KEY NOT NULL,
	`id_region` INTEGER NOT NULL REFERENCES `{$prefix}region`  (`id_region`),
	`name` VARCHAR(255) NOT NULL,
	`city` VARCHAR(255) NOT NULL REFERENCES `{$prefix}city`  (`city`),
	`street` VARCHAR(255) NOT NULL,
	`zipcode` INT(5) NOT NULL,
	`country` VARCHAR(15) NOT NULL,
	`phone` VARCHAR(15) NOT NULL,
	`openining_hours` TINYTEXT NOT NULL,
	`holiday` TEXT NOT NULL,
	`map_url` TEXT NOT NULL,
	`gpsn` DECIMAL(30,20) NOT NULL,
	`gpse` DECIMAL(30,20) NOT NULL,
	`photo_url` TEXT NOT NULL,
	`note` TEXT NOT NULL
);
EOT;

		try {
			$this->pdo->exec($sql);
		} catch (\PDOException $ex) {
			throw new Exception('Query execution failed!');
		}
	}

	/**
	 * @internal Private method used for creation extended schema.
	 * @return void
	 * @throws Exception Whenever extecuted SQL query failed.
	 */
	private function initExtendedSqlSchema()
	{
		$prefix = (string) $this->options['prefix'];
		$sql = <<<EOT
CREATE TABLE IF NOT EXISTS `{$prefix}region` (
	`id_region` INT(11) NOT NULL AUTO_INCREMENT,
	`country` VARCHAR(5) NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id_region`)
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}city` (
	`id_region` INT(11) NOT NULL,
	`city` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`city`, `id_region`),
	INDEX `fk_city_region_idx` (`id_region` ASC)
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `{$prefix}point` (
	`id_gp` VARCHAR(11) NOT NULL,
	`id_region` INT(11) NOT NULL,
	`name` VARCHAR(255) NOT NULL,
	`city` VARCHAR(255) NOT NULL,
	`street` VARCHAR(255) NOT NULL,
	`zipcode` INT(5) NOT NULL,
	`country` VARCHAR(15) NOT NULL,
	`phone` VARCHAR(15) NOT NULL,
	`openining_hours` TINYTEXT NOT NULL,
	`holiday` TINYTEXT NOT NULL,
	`map_url` TINYTEXT NOT NULL,
	`gpsn` DECIMAL(30,20) NOT NULL,
	`gpse` DECIMAL(30,20) NOT NULL,
	`photo_url` TINYTEXT NOT NULL,
	`note` TEXT NOT NULL,
	PRIMARY KEY (`id_gp`, `id_region`, `city`),
	INDEX `fk_point_region1_idx` (`id_region` ASC),
	INDEX `fk_point_city1_idx` (`city` ASC)
) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8;
EOT;

		try {
			$this->pdo->exec($sql);
		} catch (\PDOException $ex) {
			throw new Exception('Query execution failed!');
		}
	}

	/**
	 * @internal Private method used for creation simple schema for SQLite database.
	 * @return void
	 * @throws Exception Whenever extecuted SQL query failed.
	 */
	private function initSimpleSqliteSchema()
	{
		$prefix = (string) $this->options['prefix'];
		$sql = <<<EOT
CREATE TABLE IF NOT EXISTS `{$prefix}gpcache` (
  `key` varchar(255) PRIMARY KEY NOT NULL,
  `value` text NOT NULL
);
EOT;

		try {
			$this->pdo->exec($sql);
		} catch (\PDOException $ex) {
			throw new Exception('Query execution failed!');
		}
	}

	/**
	 * @internal Private method used for creation simple schema.
	 * @return void
	 * @throws Exception Whenever extecuted SQL query failed.
	 */
	private function initSimpleSqlSchema()
	{
		$prefix = (string) $this->options['prefix'];
		$sql = <<<EOT
CREATE TABLE IF NOT EXISTS `{$prefix}gpcache` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `{$prefix}gpcache` ADD PRIMARY KEY (`key`);
EOT;

		try {
			$this->pdo->exec($sql);
		} catch (\PDOException $ex) {
			throw new Exception('Query execution failed!');
		}
	}

	/**
	 * @internal
	 * @return Boolean Returns `TRUE` if (according to given `DSN`) is used database SQLite.
	 */
	private function isSqlite()
	{
		return (strpos($this->options['dsn'], 'sqlite') !== false);
	}

	/**
	 * @internal
	 * @return Boolean Returns `TRUE` if used schema type is `simple`.
	 */
	private function isSimple()
	{
		return ($this->options['schema'] === 'simple');
	}

	/**
	 * Returns `TRUE` if value with given key exists in the cache.
	 *
	 * @param string $key
	 * @return boolean
	 */
	public function exists($key)
	{
		if ($this->isSimple() !== true) {
			return $this->existsExtended($key);
		}

		$prefix = (string) $this->options['prefix'];
		$stmt = $this->pdo->prepare(
			"SELECT `value` FROM `{$prefix}gpcache` WHERE `key` = ?"
		);
		$stmt->bindParam(1, $key, \PDO::PARAM_STR);
		$res = $stmt->execute();

		if ($res === false) {
			throw new Exception('Query execution failed!');
		}

		return (count($stmt->fetchAll()) > 0);
	}

	/**
	 * @internal Version of `exists` method when extended schema is in use.
	 * @param string $key
	 * @return boolean Returns `TRUE` if value with given key exists in the cache.
	 * @throws Exception Whenever the given key is not valid!
	 * @todo Check if key is correct!
	 */
	private function existsExtended($key)
	{
		$prefix = (string) $this->options['prefix'];
		$parts = explode('|', $key);

		if (count($parts) !== 2) {
			throw new Exception('Given key is not correct!');
		}

		$sql = '';
		$val = '';

		if ($parts[0] === 'region') {
			$sql = "SELECT count(`id_region`) FROM `{$prefix}region` WHERE `country` = ?";
			$val = $parts[1];
		}
		else if ($parts[0] === 'city') {
			$sql = "SELECT count(`city`) FROM `{$prefix}city` WHERE `id_region` = ?";
			$val = $parts[1];
		}
		else if ($parts[0] === 'point') {
			$sql = "SELECT count(`id_gp`) FROM `{$prefix}point` WHERE `id_gp` = ?";
			$val = $parts[1];
		}

		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(1, $val, \PDO::PARAM_STR);
		$res = $stmt->execute();

		if ($res === false) {
			throw new Exception('Query execution failed!');
		}

		return ((int) $stmt->fetchColumn() === 1);
	}

	/**
	 * Returns value for the given key.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get($key)
	{
		if ($this->isSimple() !== true) {
			return $this->getExtended($key);
		}

		$prefix = (string) $this->options['prefix'];
		$stmt = $this->pdo->prepare(
			"SELECT `value` FROM `{$prefix}gpcache` WHERE `key` = ?"
		);
		$stmt->bindParam(1, $key, \PDO::PARAM_STR);
		$res = $stmt->execute();

		if ($res === false) {
			throw new Exception('Query execution failed!');
		}

		return unserialize($stmt->fetchColumn());
	}

	/**
	 * @internal Version of `get` method when extended schema is in use.
	 * @param string $key
	 * @return mixed Returns value for given key.
	 * @throws \GeisPointService\Cache\Exception When given key is not valid.
	 */
	private function getExtended($key)
	{
		$parts = explode('|', $key);

		if (count($parts) !== 2) {
			throw new Exception('Given key is not correct!');
		}

		switch ($parts[0]) {
			case 'region' : return $this->getExtendedRegion($parts[1]);
			case 'city'   : return $this->getExtendedCity($parts[1]);
			case 'point'  : return $this->getExtendedPoint($parts[1]);
			default:
				throw new Exception('Given key is not correct (unrecognized type)!');
		}
	}

	/**
	 * @internal
	 * @param string $country
	 * @return array|\GeisPointService\Region|NULL
	 */
	private function getExtendedRegion($country)
	{
		$prefix = (string) $this->options['prefix'];
		$sql = "SELECT * FROM `{$prefix}region` WHERE `country` = ?";

		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(1, $country, \PDO::PARAM_STR);
		$res = $stmt->execute();

		if ($res === false) {
			throw new Exception('Query execution failed!');
		}

		$ret = $stmt->fetchAll(\PDO::FETCH_CLASS, '\GeisPointService\Region');

		return (count($ret) === 0) ? null : ((count($ret) == 1) ? $ret[0] : $ret);
	}

	/**
	 * @internal
	 * @param string $id_region
	 * @return array|\GeisPointService\City|NULL
	 */
	private function getExtendedCity($id_region)
	{
		$prefix = (string) $this->options['prefix'];
		$sql = "SELECT * FROM `{$prefix}city` WHERE `id_region` = ?";

		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(1, $id_region, \PDO::PARAM_STR);
		$res = $stmt->execute();

		if ($res === false) {
			throw new Exception('Query execution failed!');
		}

		$ret = $stmt->fetchAll(\PDO::FETCH_CLASS, '\GeisPointService\City');

		return (count($ret) === 0) ? null : ((count($ret) == 1) ? $ret[0] : $ret);
	}

	/**
	 * @internal
	 * @param string $gpid
	 * @return array|\GeisPointService\Point|NULL
	 */
	private function getExtendedPoint($gpid)
	{
		$prefix = (string) $this->options['prefix'];
		$sql = "SELECT * FROM `{$prefix}point` WHERE `id_gp` = ?";

		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(1, $gpid, \PDO::PARAM_STR);
		$res = $stmt->execute();

		if ($res === false) {
			throw new Exception('Query execution failed!');
		}

		$ret = $stmt->fetchAll(\PDO::FETCH_CLASS, '\GeisPointService\Point');

		return (count($ret) === 0) ? null : ((count($ret) == 1) ? $ret[0] : $ret);
	}

	/**
	 * Adds new value into the cache.
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return boolean
	 * @throws \GeisPointService\Cache\Exception When given key is not valid.
	 * @throws \PDOException When executing of SQL query failed.
	 */
	public function set($key, $value)
	{
		if ($this->isSimple() !== true) {
			return $this->setExtended($key, $value);
		}

		$prefix = (string) $this->options['prefix'];
		$sql = $this->exists($key)
			? "UPDATE `{$prefix}gpcache` SET `value`= ? WHERE `key` = ?"
			: "INSERT INTO `{$prefix}gpcache` (`key`, `value`) VALUES (?, ?)";

		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(1, $key, \PDO::PARAM_STR);
		$stmt->bindParam(2, serialize($value), \PDO::PARAM_STR);

		return $stmt->execute();
	}

	/**
	 * @internal Version of `set` method when extended schema is in use.
	 * @param string $key
	 * @param mixed $value
	 * @return boolean
	 * @throws \GeisPointService\Cache\Exception When given key is not valid.
	 * @throws \PDOException When executing of SQL query failed.
	 */
	private function setExtended($key, $value)
	{
		$parts = explode('|', $key);

		if (count($parts) !== 2) {
			throw new Exception('Given key is not correct!');
		}

		switch ($parts[0]) {
			case 'region' : return $this->setExtendedRegion($parts[1], $value);
			case 'city'   : return $this->setExtendedCity($value);
			case 'point'  : return $this->setExtendedPoint($value);
			default:
				throw new Exception('Given key is not correct (unrecognized type)!');
		}
	}

	/**
	 * @internal
	 * @param string
	 * @param array|\GeisPointService\Region $value
	 * @return boolean
	 * @uses \GeisPointService\Cache\DbCache::setRegionInternal SQL with value(s).
	 */
	private function setExtendedRegion($country, $value)
	{
		$prefix = (string) $this->options['prefix'];
		$sql = "INSERT INTO `{$prefix}region` VALUES ";

		if (is_array($value)) {
			$values = array();

			foreach ($value as $region) {
				$values[] = $this->setExtendedRegionInternal($country, $region);
			}

			$sql .= join(',', $values);
		} else {
			$sql .= $this->setExtendedRegionInternal($country, $value);
		}

		$res = $this->pdo->exec($sql);

		return ($res !== false);
	}

	/**
	 * @internal
	 * @param string $country
	 * @param \GeisPointService\Region $region
	 * @return string Returns SQL with value(s).
	 */
	private function setExtendedRegionInternal($country, \GeisPointService\Region $region)
	{
		return '('.
			'"'.$region->id_region.'", '.
			'"'.$country.'", '.
			'"'.$region->name.'"'.
		')';
	}

	/**
	 * @internal
	 * @param array|\GeisPointService\City $value
	 * @return boolean
	 * @uses \GeisPointService\Cache\DbCache::setCityInternal SQL with value(s).
	 */
	private function setExtendedCity($value)
	{
		$prefix = (string) $this->options['prefix'];
		$sql = "INSERT INTO `{$prefix}city` VALUES ";

		if (is_array($value)) {
			$values = array();

			foreach ($value as $city) {
				$values[] = $this->setExtendedCityInternal($city);
			}

			$sql .= join(',', $values);
		} else {
			$sql .= $this->setExtendedCityInternal($value);
		}

		$res = $this->pdo->exec($sql);

		return ($res !== false);
	}

	/**
	 * @internal
	 * @param \GeisPointService\City $city
	 * @return string Returns SQL with value(s).
	 */
	private function setExtendedCityInternal(\GeisPointService\City $city)
	{
		return '('.
			'"'.$city->id_region.'", '.
			'"'.$city->city.'"'.
		')';
	}

	/**
	 * @internal
	 * @param array|\GeisPointService\Point $value
	 * @return boolean
	 * @uses \GeisPointService\Cache\DbCache::setPointInternal SQL with value(s).
	 */
	private function setExtendedPoint($value)
	{
		$prefix = (string) $this->options['prefix'];
		$sql = "INSERT INTO `{$prefix}point` VALUES ";

		if (is_array($value)) {
			$values = array();

			foreach ($value as $point) {
				$values[] = $this->setExtendedPointInternal($point);
			}

			$sql .= join(',', $values);
		} else {
			$sql .= $this->setExtendedPointInternal($value);
		}

		$res = $this->pdo->exec($sql);

		return ($res !== false);
	}

	/**
	 * @internal
	 * @param \GeisPointService\Point $point
	 * @return string Returns SQL with value(s).
	 */
	private function setExtendedPointInternal(\GeisPointService\Point $point)
	{
		return '('.
			'"'.$point->id_gp.'", '.
			'"'.$point->id_region.'", '.
			'"'.$this->pdo->quote($point->name).'", '.
			'"'.$point->city.'", '.
			'"'.$point->street.'", '.
			'"'.$point->zipcode.'", '.
			'"'.$point->country.'", '.
			'"'.$point->phone.'", '.
			'"'.$this->pdo->quote($point->openining_hours).'", '.
			'"'.$this->pdo->quote($point->holiday).'", '.
			'"'.$point->map_url.'", '.
			'"'.$point->gpsn.'", '.
			'"'.$point->gpse.'", '.
			'"'.$point->photo_url.'", '.
			'"'.$this->pdo->quote($point->note).'"'.
		')';
	}
}
