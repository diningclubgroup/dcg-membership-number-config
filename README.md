# What is this?

A package to add config to a project

# Usage

To add this library to an existing application, 

Add the following repository to the app's composer.json,
```javascript
"repositories": [
    {
        "type": "vcs",
        "url": "https://git@bitbucket.org/tastecard/dcg-lib-config.git"
    }
]
```   
            
Add the following to the _require_ section, 
```javascript
"dcg/dcg-lib-config": "dev-master"
```    

Add this to the scripts section: 
```json
"scripts": {
    "post-update-cmd": [
        "Dcg\\Config\\FileCreator::createConfigFile",        
    ]
}
```

OR, if the parent project is to be a dependancy of another project which also needs config. Create a class which extends FileCreator and specify a different source/destination config file like so:

```php
namespace Dcg\Client\MembershipNumberState\Config;

class FileCreator extends \Dcg\Config\FileCreator
{
    /**
     * Get the location of the config file to use as an example (template)
     * @param Composer\Script\Event $event
     * @return string
     */
    protected static function getSourceFile(\Composer\Script\Event $event) {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        return $vendorDir . DIRECTORY_SEPARATOR . 'dcg' . DIRECTORY_SEPARATOR . 'dcg-lib-membership-number-state-client' . DIRECTORY_SEPARATOR . 'config.php';
    }

    /**
     * Get the location of where the config file should be copied to
     * @param Composer\Script\Event $event
     * @return string
     */
    protected static function getDestinationFile(\Composer\Script\Event $event) {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        return dirname($vendorDir) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'membership-number-state-config.php';
    }
    
}
``` 

Create the config class which uses the config file specific to the project which needs config

```php
namespace Dcg\Client\MembershipNumberState;

class Config extends \Dcg\Config {

    /**
     * Get the default config file to use
     * @return string
     */
    protected static function getDefaultConfigFile() {
        return self::getRootDir().'/config/membership-number-state-config.php';
    }
}
```

* Run composer install