<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup;

use InvalidArgumentException;
use IceCake\AppConfigurator\Setup\Model\Option\Option;
use IceCake\AppConfigurator\Setup\Model\Option\OptionCollection;
use IceCake\AppConfigurator\Setup\Model\Setup;
use Symfony\Component\Yaml\Yaml;

/**
 * Description of Loader
 *
 * @author Wesley van den haak
 */
class Loader
{

    /**
     * @param string $file
     * @return Setup
     */
    public function load(string $file): Setup
    {
        $setupArray = Yaml::parseFile($file);

        // @todo validate array 
        
        $options = $this->parseOptions($setupArray['options']);
        
        // @todo parse grouping
        $groups = '';

        // @todo fill Setup model
        return new Setup($options, $groups);
    }

    /**
     * @param array $options
     * @return OptionCollection
     */
    private function parseOptions(array $options): OptionCollection
    {
        $collection = new OptionCollection();

        // Parse each option
        foreach($options as $optionSettings) {
            $option = $this->parseOption($optionSettings);
            
            $collection->append($option);
        }

        return $collection;
    }

    /**
     * @param array $option
     * @return Option
     * @throws InvalidArgumentException
     */
    private function parseOption(array $option): Option
    {
        if (class_exists($option['type']) === false) {
            $message = sprintf(
                "Option type %s does not exist.",
                $option['type']
            );
            throw new InvalidArgumentException($message);
        }
        
        // Create new object based on given type and inject value
        $typeClassname = $option['type'];
        $value = new $typeClassname($option['value']);

        $option = new Option(
            $option['key'],
            $value,
            $option['default']
        );

        return $option;
    }
}
