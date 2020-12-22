<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup\Service;

use InvalidArgumentException;
use IceCake\AppConfigurator\Setup\Model\Option\Option;
use IceCake\AppConfigurator\Setup\Model\Option\OptionCollection;

/**
 * Description of OptionParser
 *
 * @author Wesley van den haak
 */
class OptionParser
{

    /**
     * @param array $options
     * @return OptionCollection
     */
    public function parse(array $options): OptionCollection
    {
        $collection = new OptionCollection();

        // Parse each option
        foreach ($options as $optionSettings) {
            $this->validateOption($optionSettings);

            $option = $this->parseOption($optionSettings);
            $collection->append($option);
        }

        return $collection;
    }

    /**
     * @param array $option
     * @return Option
     */
    private function parseOption(array $option): Option
    {
        // Create new object based on given type and inject value
        $typeClassname = $option['type'];
        $value = new $typeClassname($option['value']);

        // Default is null. If a value is give parse it into a Value object to
        // enforce same basic value (e.g. both int or string)
        $default = null;
        if (!empty($option['default'])) {
            $default = new $typeClassname($option['default']);
        }

        return new Option(
            $option['key'],
            $value,
            $default
        );
    }

    /**
     * @todo: Create separate validator class
     *
     * @param array $option
     * @return void
     * @throws InvalidArgumentException
     */
    private function validateOption(array $option): void
    {
        // Check if option has a value key and the contents are not empty.
        if (empty($option['key'])) {
            throw new InvalidArgumentException("Option missing required 'key' property.");
        }

        // Check if an valid option type class is given
        if (empty($option['type'])) {
            throw new InvalidArgumentException("Option missing required 'type' property.");
        }

        if(class_exists($option['type']) === false) {
            $message = sprintf(
                "Option type class %s does not exist.",
                $option['type']
            );

            throw new InvalidArgumentException($message);
        }

        // Check if option has a value key and the contents are not empty.
        // @todo: check not empty (note: boolean values are allowed)
        if (isset($option['value']) === false) {
            $message = sprintf(
                "Value for option with key %s may not be empty.",
                $option['key']
            );

            throw new InvalidArgumentException($message);
        }
    }
}