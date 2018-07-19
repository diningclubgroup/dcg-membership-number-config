<?php

use \Dcg\Config;
use PHPUnit\Framework\TestCase;


class ConfigTest extends TestCase
{

    public function testConfigLoadsSpecificFile()
    {
        $config = Config::getInstance(__DIR__ . '/../config.php');
        $this->assertNotEmpty($config->get());
    }

    public function testConfigLoads()
    {
        $config = Config::getInstance(__DIR__ . '/../config.php');
        $this->assertNotEmpty($config->get());
    }

    public function testConfigReturnsValue()
    {
        $config = Config::getInstance(__DIR__ . '/../config.php');
        $configValues = $config->get();
        $this->assertArrayHasKey('live', $configValues);
    }

}