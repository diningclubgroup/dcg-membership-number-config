<?php

namespace Dcg;
use Dcg\Config\Exception\ConfigFileNotFoundException;
use Dcg\Config\Exception\ConfigValueNotFoundException;

class Config {

    /**
     * @var array
     */
    protected $configValues = [];

    protected static $instance = [];

    private function __construct()
    {
        // cannot instantiate
    }

    /**
     * singleton: return self
     *
     * First call should specify a config file
     *
     * @param string $configFile (Optional) The absolute filename of the config file
     * @return self
     * @throws ConfigFileNotFoundException
     */
    public static function getInstance($configFile = null) {

        if (!$configFile) {
            $configFile = static::getDefaultConfigFile();
        }
        if (!isset(self::$instance[$configFile])) {
            self::$instance[$configFile] = new static();
            self::$instance[$configFile]->configFileToArray($configFile);
        }
        return self::$instance[$configFile];
    }

    /**
     * Get the default config file to use
     * @return string
     */
    protected static function getDefaultConfigFile() {
        return self::getRootDir().'/config.php';
    }

    /**
     * Get values from config file
     *
     * @param string $configFile The config filename
     * @throws ConfigFileNotFoundException
     */
    protected function configFileToArray($configFile) {

        if (file_exists($configFile)) {
            $this->configValues = require $configFile;
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
            return $this->configValues;
        } else if (isset($this->configValues[$key])) {
            return $this->configValues[$key];
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
    protected static function getRootDir() {
        $dir = dirname(__FILE__);
        if (false !== ($position = strpos($dir, DIRECTORY_SEPARATOR . 'vendor'))) {
            return substr($dir, 0, $position);
        }
        return false;
    }
}