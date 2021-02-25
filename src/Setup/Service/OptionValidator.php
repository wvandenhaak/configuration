<?php

declare(strict_types=1);

namespace wvandenhaak\configuration\Setup\Service;

use Wvandenhaak\Configuration\Common\Contract\OptionProviderInterface;
use Wvandenhaak\Configuration\Common\Enum\OptionEnum;
use Wvandenhaak\Configuration\Common\Exception\ValidationException;

/**
 * A validator to validate an array of options on required keys and values
 */
class OptionValidator
{

    /**
     * @param array $option
     * @throws ValidationException
     */
    public function validate(array $option): void
    {

        // Check if option has a value key and the contents are not empty.
        if (empty($option[OptionEnum::KEY_KEY])) {
            throw new ValidationException(sprintf(
                "Option missing required '%s' property.",
                OptionEnum::KEY_KEY
            ));
        }

        // Check if an valid option type class is given
        if (empty($option[OptionEnum::KEY_TYPE])) {
            throw new ValidationException(sprintf(
                "Option missing required '%s' property.",
                OptionEnum::KEY_TYPE
            ));
        }

        // Check if given class exists
        if (class_exists($option[OptionEnum::KEY_TYPE]) === false) {
            throw new ValidationException(sprintf(
                "Option type class %s does not exist.",
                $option[OptionEnum::KEY_TYPE]
            ));
        }

        // Check if option has a list of choices
        if (isset($option[OptionEnum::KEY_CHOICES]) && !is_array($option[OptionEnum::KEY_CHOICES])) {
            throw new ValidationException(sprintf(
                "%s for option with key %s must be an array.",
                ucfirst(OptionEnum::KEY_CHOICES),
                $option[OptionEnum::KEY_KEY]
            ));
        }
    }

    /**
     * @param array $option
     * @throws ValidationException
     */
    public function validateProvider(array $option): void
    {
        // Check if option has a value key and the contents are not empty.
        if (empty($option[OptionEnum::KEY_KEY])) {
            throw new ValidationException(sprintf(
                "Option missing required '%s' property.",
                OptionEnum::KEY_KEY
            ));
        }

        if (empty($option[OptionEnum::KEY_PROVIDER])) {
            throw new ValidationException(sprintf(
                "'%s' property may noy be empty.",
                OptionEnum::KEY_PROVIDER
            ));
        }

        $className = $option[OptionEnum::KEY_PROVIDER];

        // Check if given class exists
        if (class_exists($className) === false) {
            throw new ValidationException(sprintf(
                "OptionProvider class %s does not exist.",
                $className
            ));
        }

        // Check if class implements the OptionProviderInterface
        $interfaces = class_implements($className);
        if (in_array(OptionProviderInterface::class, $interfaces) === false) {
            throw new ValidationException(sprintf(
                "OptionProvider class %s does not implement the required interface '%s'.",
                $className,
                OptionProviderInterface::class
            ));
        }
    }
}