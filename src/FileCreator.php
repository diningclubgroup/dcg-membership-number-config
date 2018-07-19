<?php

namespace Dcg\Config;

class FileCreator {

	/**
	 *  Copy package's config file to project
	 */
	public static function createConfigFile ($event, $sourceFile = null, $destinationFile = null)
	{
		$vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        if (null === $sourceFile) {
            $sourceFile = $vendorDir . DIRECTORY_SEPARATOR . 'dcg' . DIRECTORY_SEPARATOR . 'dcg-lib-config' . DIRECTORY_SEPARATOR . 'config.php';
        }
		if (null === $destinationFile) {
            $configDir = dirname($vendorDir) . DIRECTORY_SEPARATOR . 'config';
            $destinationFile = $configDir . DIRECTORY_SEPARATOR . 'config.php';
        }

		if (!file_exists($destinationFile)) {
			mkdir(dirname($destinationFile), 0777, true);
		}
		if (!file_exists($destinationFile)) {
			copy($sourceFile, $destinationFile);
		}
	}

}