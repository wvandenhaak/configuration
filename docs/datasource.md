Datasource(s)
=============
A Datasource is used to load a Setup of Config into the corresponding Setup/Config model.

## Default Datasource
This package offers a few Datasources by default.

### ArrayDataSource
Class: ```IceCake\AppConfigurator\Common\DataSource\ArrayDataSource```

Can load a returned array from a PHP-file. The PHP-file will be imported using ```require '<filename>'```.

The file must have at least the following contents:
```php
// Config
return [
    'configuration' => [
        // KEY => VALUES
    ]        
];


// Setup
return [
    'setup' => [
        'options' => [
            // OPTIONS
        ],
        'groups' => [
            // GROUPS
        ]
    ]
];
```

### YamlDataSource
Class: ```IceCake\AppConfigurator\Common\DataSource\YamlDataSource```

Can load a YAML-file. The YamlDatasource uses the [symfony/yaml](https://github.com/symfony/yaml) package for loading and parsing YAML.

The file must have at least  the following contents:
```yaml
# Config
configuration:
    # List of KEY => VALUES

# Setup
setup:
    options:
        # List of options
    
    groups:
        # List of groups
```

## Custom Datasource
This package allows the use of custom Datasources. This allows the use of other ways to retrieve the Config/Setup information. From a database for example.

Custom Datasources must implement the ```IceCake\AppConfigurator\Common\Contract\DataSourceInterface``` interface.