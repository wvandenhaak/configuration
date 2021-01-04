Datastore(s)
============
A Datastore is used to save the Config.

## Default Datastore(s)
This package offers a few Datastores by default.

### ArrayDataStore
Class: ```IceCake\AppConfigurator\Common\DataStore\ArrayDataStore```

Can save a Config into a PHP-file (which returns an array).

### YamlDataStore
Class: ```IceCake\AppConfigurator\Common\DataStore\YamlDataStore```

Can save a Config into an YAML-file. The YamlDataStore uses the [symfony/yaml](https://github.com/symfony/yaml) package for parsing and writing YAML.

## Custom Datastores
This package allows the use of custom Datastores. This allows the use of other ways to save the Config/Setup information. To a database for example.

Custom Datastores must implement the ```IceCake\AppConfigurator\Common\Contract\DataStoreInterface``` interface.