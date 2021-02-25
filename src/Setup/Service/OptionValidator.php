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
    public function validateOption(array $option): void
    {
        $this->validateKey($option);
        $this->validateChoices($option);

        $this->validateType($option);
        $this->validateClassExists($option, OptionEnum::KEY_TYPE);
    }

    /**
     * @param array $option
     * @throws ValidationException
     */
    public function validateOptionProvider(array $option): void
    {
        $this->validateKey($option);
        $this->validateProvider($option);
    }

    /**
     * Check if the array key for 'key' is defined and is not empty.
     * @param array $option
     * @return void
     * @throws ValidationException
     */
    private function validateKey(array $option): void
    {
        if (empty($option[OptionEnum::KEY_KEY])) {
            throw new ValidationException(sprintf(
                "Missing required '%s' property.",
                OptionEnum::KEY_KEY
            ));
        }
    }

    /**
     * Validate if the array key for 'type' is defined and it not empty
     * @param array $option
     * @return void
     * @throws ValidationException
     */
    private function validateType(array $option): void
    {
        // Check if an valid option type class is given
        if (empty($option[OptionEnum::KEY_TYPE])) {
            throw new ValidationException(sprintf(
                "Missing required '%s' property.",
                OptionEnum::KEY_TYPE
            ));
        }
    }

    /**
     * Validate if the array key for 'choices' is defined
     * @param array $option
     * @return void
     * @throws ValidationException
     */
    private function validateChoices(array $option): void
    {
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
     * Validate if the array key for 'provider' is defined and contains a valid/usable classname
     * @param array $option
     * @return void
     * @throws ValidationException
     */
    private function validateProvider(array $option): void
    {
        $key = OptionEnum::KEY_PROVIDER;

        if (empty($option[$key])) {
            throw new ValidationException(sprintf(
                "'%s' property may noy be empty.",
                OptionEnum::KEY_PROVIDER
            ));
        }

        $this->validateClassExists($option, $key);

        // Check if class implements the OptionProviderInterface
        $className = $option[$key];
        $interfaces = class_implements($className);
        if (in_array(OptionProviderInterface::class, $interfaces) === false) {
            throw new ValidationException(sprintf(
                "OptionProvider class %s does not implement the required interface '%s'.",
                $className,
                OptionProviderInterface::class
            ));
        }
    }

    /**
     * @param array $option
     * @param string $key
     * @return void
     */
    private function validateClassExists(array $option, string $key): void
    {
        $className = $option[$key];

        if (class_exists($className) === false) {
            throw new ValidationException(sprintf(
                "Class %s for key '%s' does not exist.",
                $className,
                $key
            ));
        }
    }
}