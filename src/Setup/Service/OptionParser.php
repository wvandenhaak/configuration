<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Setup\Service;

use Wvandenhaak\Configuration\Common\Enum\OptionEnum;
use Wvandenhaak\Configuration\Common\Exception\ParseException;
use Wvandenhaak\Configuration\Common\Exception\ValidationException;
use Wvandenhaak\Configuration\Setup\Model\Option\Option;
use Wvandenhaak\Configuration\Setup\Model\Option\OptionCollection;
use Wvandenhaak\Configuration\Setup\Service\OptionValidator;

/**
 * A class to parse an array op option values into an Option object
 */
class OptionParser
{

    private OptionValidator $validator;

    /**
     * @param OptionValidator $validator
     */
    public function __construct(OptionValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array $options
     * @return OptionCollection
     * @throws ValidationException
     * @throws ParseException
     */
    public function parse(array $options): OptionCollection
    {
        $collection = new OptionCollection();

        // Parse each option
        foreach ($options as $optionSettings) {

            // Validate Option or OptionProvider
            if (array_key_exists(OptionEnum::KEY_PROVIDER, $optionSettings)) {
                $this->validator->validateOptionProvider($optionSettings);
                $option = $this->parseOptionProvider($optionSettings);
            } else {
                $this->validator->validateOption($optionSettings);
                $option = $this->parseOption($optionSettings);
            }

            $collection->append($option);
        }

        return $collection;
    }

    /**
     * @param array $option
     * @return Option
     * @throws ParseException
     */
    private function parseOption(array $option): Option
    {
        // Create new object based on given type and inject value
        $typeClassname = $option[OptionEnum::KEY_TYPE];

        // Get all possible choices
        $choices = [];
        if (isset($option[OptionEnum::KEY_CHOICES])) {
            $optionChoices = $option[OptionEnum::KEY_CHOICES];

            foreach ($optionChoices as $choice) {
                if (is_array($choice)) {
                    throw new ParseException('Multi-dimensional array of choices is not supported');
                }
            }
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

}