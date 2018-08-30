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

    public function testConfigReturnsValueForProd()
    {
        $config = Config::getInstance(__DIR__ . '/../config.php');
        $configValues = $config->get();
        $this->assertArrayHasKey('live', $configValues);
        $this->assertTrue($config->get('live'));
    }

    public function testConfigReturnsValueForTest()
    {
        $config = Config::getInstance(__DIR__ . '/../config.php', Config::ENV_TEST);
        $configValues = $config->get();
        $this->assertArrayHasKey('live', $configValues);
        $this->assertFalse($config->get('live'));
    }

}