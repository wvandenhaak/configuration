<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Setup\Service;

use Wvandenhaak\Configuration\Common\Enum\OptionEnum;
use Wvandenhaak\Configuration\Common\Exception\ParseException;
use Wvandenhaak\Configuration\Common\Contract\OptionProviderInterface;
use Wvandenhaak\Configuration\Setup\Model\Option\Option;
use Wvandenhaak\Configuration\Setup\Model\Option\OptionCollection;

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

            // Validate option or optionProvider
            if (array_key_exists(OptionEnum::KEY_PROVIDER, $optionSettings)) {
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
        $typeClassname = $option[OptionEnum::KEY_TYPE];

        // Get all possible choices
        $choices = [];
        if (isset($option[OptionEnum::KEY_CHOICES])) {
            // @todo validate choices does not contain array in array
            $choices = $option[OptionEnum::KEY_CHOICES];
        }

        // Default is null. If a value is give parse it into a Value object to force value to be
        $default = null;
        if (isset($option[OptionEnum::KEY_DEFAULT]) && $option[OptionEnum::KEY_DEFAULT] !== null) {
            $default = new $typeClassname($option[OptionEnum::KEY_DEFAULT]);
        }

        return new Option(
            $option[OptionEnum::KEY_KEY],
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
        $key = $option[OptionEnum::KEY_KEY];
        $className = $option[OptionEnum::KEY_PROVIDER];

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
     * @throws ParseException
     */
    private function validateOption(array $option): void
    {
        // Check if option has a value key and the contents are not empty.
        if (empty($option[OptionEnum::KEY_KEY])) {
            throw new ParseException(sprintf(
                "Option missing required '%s' property.",
                OptionEnum::KEY_KEY
            ));
        }

        // Check if an valid option type class is given
        if (empty($option[OptionEnum::KEY_TYPE])) {
            throw new ParseException(sprintf(
                "Option missing required '%s' property.",
                OptionEnum::KEY_TYPE
            ));
        }

        // Check if given class exists
        if(class_exists($option[OptionEnum::KEY_TYPE]) === false) {
            throw new ParseException(sprintf(
                "Option type class %s does not exist.",
                $option[OptionEnum::KEY_TYPE]
            ));
        }

        // Check if option has a list of choices
        if (isset($option[OptionEnum::KEY_CHOICES]) && !is_array($option[OptionEnum::KEY_CHOICES])) {
            throw new ParseException(sprintf(
                "%s for option with key %s must be an array.",
                ucfirst(OptionEnum::KEY_CHOICES),
                $option[OptionEnum::KEY_KEY]
            ));
        }
    }

    /**
     * @todo: Create separate validator class
     *
     * @param array $option
     * @return void
     * @throws ParseException
     */
    private function validateOptionProvider(array $option): void
    {
        // Check if option has a value key and the contents are not empty.
        if (empty($option[OptionEnum::KEY_KEY])) {
            throw new ParseException(sprintf(
                "Option missing required '%s' property.",
                OptionEnum::KEY_KEY
            ));
        }

        if (empty($option[OptionEnum::KEY_PROVIDER])) {
            throw new ParseException(sprintf(
                "'%s' property may noy be empty.",
                OptionEnum::KEY_PROVIDER
            ));
        }

        $className = $option[OptionEnum::KEY_PROVIDER];

        // Check if given class exists
        if(class_exists($className) === false) {
            throw new ParseException(sprintf(
                "OptionProvider class %s does not exist.",
                $className
            ));
        }

        // Check if class implements the OptionProviderInterface
        $interfaces = class_implements($className);
        if (in_array(OptionProviderInterface::class, $interfaces) === false) {
            throw new ParseException(sprintf(
                "OptionProvider class %s does not implement the required interface '%s'.",
                $className,
                OptionProviderInterface::class
            ));
        }
    }
}