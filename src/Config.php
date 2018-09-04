<?php

namespace Dcg;
use Dcg\Config\Exception\ConfigFileNotFoundException;
use Dcg\Config\Exception\ConfigValueNotFoundException;

class Config {

    const ENV_PROD = 'prod';
    const ENV_TEST = 'test';

    /**
     * @var array
     */
    protected $configValues = [];

    protected static $instance = [];
    private $env;

    /**
     * Config constructor.
     * @param string $env The enviroment to read config values for. prod or test
     */
    private function __construct($env = self::ENV_PROD)
    {
        $this->env = $env;
    }

    /**
     * singleton: return self
     *
     * First call should specify a config file
     *
     * @param string $configFile (Optional) The absolute filename of the config file
     * @param string $env The enviroment to read config values for. prod or test
     * @return self
     */
    public static function getInstance($configFile = null, $env = self::ENV_PROD) {

        if (!$configFile) {
            $configFile = static::getDefaultConfigFile();
        }
        if (!isset(self::$instance[$configFile][$env])) {
            self::$instance[$configFile][$env] = new static($env);
            self::$instance[$configFile][$env]->configFileToArray($configFile);
        }
        return self::$instance[$configFile][$env];
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
            return $this->configValues[$this->env];
        } else if (isset($this->configValues[$this->env][$key])) {
            return $this->configValues[$this->env][$key];
        } elseif ($default !== null) {
            return $default;
        } else {
            throw new ConfigValueNotFoundException("The config value was not found: " . $key);
        }
    }

    /**
     * Gets the root dir, assumed to be one level above vendor
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