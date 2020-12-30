wvandenhaak/app-configurator
============================

This package provides simple-to-use (custom)configuration files.

[![PHPUnit](https://github.com/wvandenhaak/app-configurator/workflows/PHPUnit/badge.svg)](https://github.com/wvandenhaak/app-configurator/actions)

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
options: 
    # string
    - {
        key: 'key_1',
        type: 'IceCake\AppConfigurator\Common\Value\Option\StringType',
    }

    # array
    - {
        key: 'key_2',
        type: 'IceCake\AppConfigurator\Common\Value\Option\ArrayType',
        choices: [value_2_1, value_2_2, value_2_3, value_2_4],
    }

    # boolean
    - {
        key: 'key_3',
        type: 'IceCake\AppConfigurator\Common\Value\Option\BooleanType',
        default: false
    }

    # int
    - {
        key: 'key_4',
        type: 'IceCake\AppConfigurator\Common\Value\Option\IntegerType',
    }

    # Custom class to retrieve option values from.
    # Class must implement IceCake\AppConfigurator\Common\Contract\OptionProviderInterface 
    - {
      key: 'key_5',
      provider: 'IceCake\AppConfigurator\Tests\data\classes\CustomOptionProvider'
    }

groups:
    - {name: Group 1, keys: [key_1, key_2] }
    - {name: Group 2, keys: [key_3, key_4] }
    - {name: Group 3, keys: [key_5] }
```

## Step 3: Load or Generate a Configuration
Loading from an existing configuration file (if you already have one):
```php
use IceCake\AppConfigurator\Common\DataSource\ArrayDataSource;
use IceCake\AppConfigurator\Config\Service\Loader;
use IceCake\AppConfigurator\Config\Service\Parser;

$parser = new Parser();
$loader = new Loader($parser);

$filePath = 'configuration.php';
$dataSource = new ArrayDataSource($filePath);

$config = $loader->load($dataSource);

// $config->get(...)
```

Generate from setup file (from step 2):
```php
use IceCake\AppConfigurator\Common\DataSource\YamlDataSource;
use IceCake\AppConfigurator\Setup\Service\GroupParser;
use IceCake\AppConfigurator\Setup\Service\Loader;
use IceCake\AppConfigurator\Setup\Service\OptionParser;

$groupParser = new GroupParser();
$optionParser = new OptionParser();
$loader = new Loader($groupParser, $optionParser);

$dataSource = new YamlDataSource('configuration-setup.yaml');

$setup = $loader->load($dataSource);

// $setup->get(...)
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