<?php

namespace Dcg\Config;

class FileCreator {

	/**
	 *  Copy package's config file to project
	 */
	public static function createConfigFile (\Composer\Script\Event $event)
	{
        $sourceFile = self::getSourceDir($event);
        $destinationFile = self::getSourceDir($event);

		if (!file_exists($destinationFile)) {
			mkdir(dirname($destinationFile), 0777, true);
		}
		if (!file_exists($destinationFile)) {
			copy($sourceFile, $destinationFile);
		}
	}

    /**
     * Get the location of the config file to use as an example (template)
     * @param Composer\Installer\PackageEvent $event
     * @return string
     */
	protected static function getSourceFile(\Composer\Script\Event $event) {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        return $vendorDir . DIRECTORY_SEPARATOR . 'dcg' . DIRECTORY_SEPARATOR . 'dcg-lib-config' . DIRECTORY_SEPARATOR . 'config.php';
    }

    /**
     * Get the location of the config file to use as an example (template)
     * @param Composer\Installer\PackageEvent $event
     * @return string
     */
    protected static function getDestinationFile(\Composer\Script\Event $event) {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $configDir = dirname($vendorDir) . DIRECTORY_SEPARATOR . 'config';
        return $configDir . DIRECTORY_SEPARATOR . 'config.php';
    }

}