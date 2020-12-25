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

    private const KEY_KEY = 'key';
    private const KEY_CHOICES = 'choices';
    private const KEY_DEFAULT = 'default';
    private const KEY_TYPE = 'type';

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
        $typeClassname = $option[self::KEY_TYPE];

        // Get all possible choices
        $choices = [];
        if (isset($option[self::KEY_CHOICES])) {
            foreach($option[self::KEY_CHOICES] as $choice) {
                $choices[] = $choice;
            }
        }

        // Default is null. If a value is give parse it into a Value object to force value to be
        $default = null;
        if (isset($option[self::KEY_DEFAULT]) && $option[self::KEY_DEFAULT] !== null) {
            $default = new $typeClassname($option[self::KEY_DEFAULT]);
        }

        return new Option(
            $option[self::KEY_KEY],
            $default,
            $choices
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
        if (empty($option[self::KEY_KEY])) {
            $message = sprintf(
                "Option missing required '%s' property.",
                self::KEY_KEY
            );

            throw new InvalidArgumentException($message);
        }

        // Check if an valid option type class is given
        if (empty($option[self::KEY_TYPE])) {
            $message = sprintf(
                "Option missing required '%s' property.",
                self::KEY_TYPE
            );

            throw new InvalidArgumentException($message);
        }

        // Check if given class exists
        if(class_exists($option[self::KEY_TYPE]) === false) {
            $message = sprintf(
                "Option type class %s does not exist.",
                $option[self::KEY_TYPE]
            );

            throw new InvalidArgumentException($message);
        }

        // Check if option has a list of choices
        if (isset($option[self::KEY_CHOICES]) && !is_array($option[self::KEY_CHOICES])) {
            $message = sprintf(
                "%s for option with key %s must be an array.",
                ucfirst(self::KEY_CHOICES),
                $option[self::KEY_KEY]
            );

            throw new InvalidArgumentException($message);
        }
    }
}