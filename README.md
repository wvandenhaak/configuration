wvandenhaak/configuration
============================

This package provides simple-to-use (custom)configuration files.

![PHPUnit](https://github.com/wvandenhaak/configuration/workflows/PHPUnit/badge.svg)

Installation
============

## Step 1: Installation
Install this package using Composer with the following command:

```
composer require wvandenhaak/app-configurator
```

## Step 2: Configuration/Setup
Create a configuration setup file (YAML is used in this example) to your needs. 
This fill holds all available options, value types and default values.

```yaml
# configuration-setup.yaml
setup:
    options: 
        # string
        - {
            key: 'key_1',
            type: 'Wvandenhaak\Configuration\Common\Value\Option\StringType',
        }
    
        # array
        - {
            key: 'key_2',
            type: 'Wvandenhaak\Configuration\Common\Value\Option\ArrayType',
            choices: [value_2_1, value_2_2, value_2_3, value_2_4],
            default: [value_2_2, value_2_4]
        }
    
        # boolean
        - {
            key: 'key_3',
            type: 'Wvandenhaak\Configuration\Common\Value\Option\BooleanType',
            default: false
        }
    
        # int
        - {
            key: 'key_4',
            type: 'Wvandenhaak\Configuration\Common\Value\Option\IntegerType',
        }
    
        # Custom class to retrieve option values from.
        # Class must implement Wvandenhaak\Configuration\Common\Contract\OptionProviderInterface 
        - {
          key: 'key_5',
          provider: 'Wvandenhaak\Configuration\Tests\data\classes\CustomOptionProvider'
        }
    
    groups:
        - {name: Group 1, keys: [key_1, key_2] }
        - {name: Group 2, keys: [key_3, key_4] }
        - {name: Group 3, keys: [key_5] }
```

## Step 3: Load or Generate a Configuration
Loading from an existing configuration file (if you already have one):
```php
use Wvandenhaak\Configuration\Common\DataSource\ArrayDataSource;
use Wvandenhaak\Configuration\Config\Service\Loader;
use Wvandenhaak\Configuration\Config\Service\Parser;

$parser = new Parser();
$loader = new Loader($parser);

$filePath = 'configuration.php';
$dataSource = new ArrayDataSource($filePath);

$config = $loader->load($dataSource);

// $config->get(...)
```

Generate from setup file (from step 2):
```php
use Wvandenhaak\Configuration\Common\DataSource\YamlDataSource;
use Wvandenhaak\Configuration\Setup\Service\GroupParser;
use Wvandenhaak\Configuration\Setup\Service\Loader;
use Wvandenhaak\Configuration\Setup\Service\OptionParser;

$groupParser = new GroupParser();
$optionParser = new OptionParser();
$loader = new Loader($groupParser, $optionParser);

// Or use Wvandenhaak\Configuration\Common\DataSource\DataSourceFactory
$dataSource = new YamlDataSource('configuration-setup.yaml');

$setup = $loader->load($dataSource);

// $setup->get(...)
```

## Step 4: Save/write a Config to disk
```php
use Wvandenhaak\Configuration\Common\DataStore\ArrayDataStore;
use Wvandenhaak\Configuration\Common\Value\File\FileNameValue;
use Wvandenhaak\Configuration\Common\Value\File\FolderValue;
use Wvandenhaak\Configuration\Config\Model\Config;
use Wvandenhaak\Configuration\Config\Service\Writer;

$writer = new Writer();

$folder = new FolderValue('path/to/directory');
$filename = new FileNameValue('file_name', 'extension');

// Or use Wvandenhaak\Configuration\Common\DataStore\DataStoreFactory
$dataStore = new ArrayDataStore($folder, $filename);

// The config to save
$config = new Config( ... ); 

$writer->save($config, $dataStore);
```

Usage
=====
This package has two types of Configuration models
- **Setup**: An object representation of the setup file. Holds all the key-value pairs, default values, value choice options and groups.
- **Config**: A simplified version of the Setup model. Holds only the key-value pairs of the configuration

**Setup use cases:**
- When creating webinterfaces for modifying configuration values (e.g. to show which configuration option belong to the same group)
- Validating Configs for missing keys, invalid values, etc.

**Config use cases**
- Faster parsing time (e.g. A page which only has to show the configured values does not need the full Setup model)

Documentation
=============

More documentation can be found in the ```docs``` folder.