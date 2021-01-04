Configuration Setup
=========

Basic package configuration (YAML format)
```yaml
# package-config.yaml
setup:
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
        - {name: Random name, keys: [key_5] }
```

## Options
An Option holds a specific configuration setting. An Option consists out of the following elements: 
- **key**: [required] An unique name which is used to retrieve the corresponding values from the Option.
- **type**: [required] A reference to a class. This class will be used for validating the (default)value for this Option.
- **choices**: [optional] A list of possible values (or null) to choose from
- **default**: [optional] The default value. The default value will be used when creating new configs.

### Type customization
This package offers the following option types:
- `IceCake\AppConfigurator\Common\Value\Option\StringType` forces that the value is a string
- `IceCake\AppConfigurator\Common\Value\Option\ArrayType` forces that the value is an array
- `IceCake\AppConfigurator\Common\Value\Option\BooleanType` forces that the value is a boolean
- `IceCake\AppConfigurator\Common\Value\Option\IntegerType` forces that the value is an integer

The use of custom types is possible. Custom types must use the `IceCake\AppConfigurator\Common\Contract\OptionValueInterface` interface.

## Groups
All the defined options can be grouped. Each group has a name, and a list of keys.
- **name**: The name of the group.
- **keys**: A list of keys (as defined in the ```key``` of the Option) which belong in this group.