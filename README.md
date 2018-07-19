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

```json

``` 


* Run composer install