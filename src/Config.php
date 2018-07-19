<?php

namespace Dcg;
use Dcg\Config\Exception\ConfigFileNotFoundException;
use Dcg\Config\Exception\ConfigValueNotFoundException;

class Config {

	/**
	 * @var array
	 */
	protected static $configValues = [];

	private function __construct()
    {
        // cannot instantiate
    }

    /**
     * singleton: return self
     *
     * @param string $configFile (Optional) The absolute filename of the config file
     * @return self
     * @throws ConfigFileNotFoundException
     */
	public static function getInstance($configFile) {

        static $instance = null;

		if (null === $instance) {
            $instance = new static();
		}
        self::configFileToArray($configFile);
		return $instance;
	}

	/**
	 * Get values from config file
	 *
	 * @param string $configFile The config filename
	 * @throws ConfigFileNotFoundException
	 */
	private static function configFileToArray($configFile) {

		if (file_exists($configFile)) {
			self::$configValues = require $configFile;
		} else {
			throw new ConfigFileNotFoundException("Config file could not be found at: ".$configFile);
		}
	}

	/**
	 * Gets specific key fom config
	 *
	 * @param string $key	The config value identifier
	 * @param string $default (Optional) The default value if the config value is not set
	 * @throws ConfigValueNotFoundException
	 * @return string
	 */
    public function get($key = null, $default = null)
    {
        if (null === $key) {
            return self::$configValues;
        } else if (isset(self::$configValues[$key])) {
            return self::$configValues[$key];
        } elseif ($default !== null) {
            return $default;
        } else {
            throw new ConfigValueNotFoundException("The config value was not found: " . $key);
        }
    }

	/**
	 * Gets the root dir, assumed to be once level above vendor
	 * @return bool|string
	 */
	private static function getRootDir() {
		$dir = dirname(__FILE__);
		if (false !== ($position = strpos($dir, DIRECTORY_SEPARATOR . 'vendor'))) {
			return substr($dir, 0, $position);
		}
		return false;
	}
}