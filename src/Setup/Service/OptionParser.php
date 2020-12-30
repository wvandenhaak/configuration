<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup\Service;

use InvalidArgumentException;
use IceCake\AppConfigurator\Common\Contract\OptionProviderInterface;
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
    private const KEY_PROVIDER = 'provider';

    /**
     * @param array $options
     * @return OptionCollection
     */
    public function parse(array $options): OptionCollection
    {
        $collection = new OptionCollection();

        // Parse each option
        foreach ($options as $optionSettings) {

            // Validate option or optionProvider
            if (array_key_exists(self::KEY_PROVIDER, $optionSettings)) {
                $this->validateOptionProvider($optionSettings);
                $option = $this->parseOptionProvider($optionSettings);
            } else {
                $this->validateOption($optionSettings);
                $option = $this->parseOption($optionSettings);
            }

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
            // @todo validate choices does not contain array in array
            $choices = $option[self::KEY_CHOICES];
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
     * @param array $option
     * @return Option
     */
    private function parseOptionProvider(array $option): Option
    {
        $key = $option[self::KEY_KEY];
        $className = $option[self::KEY_PROVIDER];

        return new Option(
            $key,
            $className::getDefaultValue(),
            $className::getChoices()
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

    /**
     * @todo: Create separate validator class
     *
     * @param array $option
     * @return void
     * @throws InvalidArgumentException
     */
    private function validateOptionProvider(array $option): void
    {
        // Check if option has a value key and the contents are not empty.
        if (empty($option[self::KEY_KEY])) {
            $message = sprintf(
                "Option missing required '%s' property.",
                self::KEY_KEY
            );

            throw new InvalidArgumentException($message);
        }

        if (empty($option[self::KEY_PROVIDER])) {
            $message = sprintf(
                "'%s' property may noy be empty.",
                self::KEY_PROVIDER
            );

            throw new InvalidArgumentException($message);
        }

        $className = $option[self::KEY_PROVIDER];

        // Check if given class exists
        if(class_exists($className) === false) {
            $message = sprintf(
                "OptionProvider class %s does not exist.",
                $className
            );

            throw new InvalidArgumentException($message);
        }

        // Check if class implements the OptionProviderInterface
        $interfaces = class_implements($className);
        if (in_array(OptionProviderInterface::class, $interfaces) === false) {
            $message = sprintf(
                "OptionProvider class %s does not implement the required interface '%s'.",
                $className,
                OptionProviderInterface::class
            );

            throw new InvalidArgumentException($message);
        }
    }
}