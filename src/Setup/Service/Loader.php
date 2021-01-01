<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup\Service;

use IceCake\AppConfigurator\Config\Model\Config;
use InvalidArgumentException;
use IceCake\AppConfigurator\Common\Contract\DataSourceInterface;
use IceCake\AppConfigurator\Setup\Model\Setup;
use IceCake\AppConfigurator\Setup\Service\GroupParser;
use IceCake\AppConfigurator\Setup\Service\OptionParser;

/**
 * Description of Loader
 *
 * @author Wesley van den haak
 */
class Loader
{
    private const SETUP_KEY_OPTIONS = 'options';
    private const SETUP_KEY_GROUPS = 'groups';

    private GroupParser $groupParser;
    private OptionParser $optionParser;

    /**
     * @param GroupParser $groupParser
     * @param OptionParser $optionParser
     */
    public function __construct(
        GroupParser $groupParser,
        OptionParser $optionParser
    )
    {
        $this->groupParser = $groupParser;
        $this->optionParser = $optionParser;
    }

    /**
     * @param DataSourceInterface $dataSource
     * @return Setup
     */
    public function load(DataSourceInterface $dataSource): Setup
    {
        // Load
        $dataSource->validate();
        $setup = $dataSource->load();

        // Validate
        $this->validate($setup);

        // Parsing
        $options = $this->optionParser->parse($setup[self::SETUP_KEY_OPTIONS]);
        $groups = $this->groupParser->parse($options, $setup[self::SETUP_KEY_GROUPS]);

        // Create Config object
        // @todo move options array to different class so this loop can be moved (also remove getIterator mocking from PHPUnit
        $elements = [];
        foreach ($options as $option) {
            $elements[$option->getKey()] = $option->getDefaultValue();
        }

        $config = new Config($elements);

        return new Setup($options, $groups, $config);
    }

    /**
     * @param array $setup
     * @return void
     * @throws InvalidArgumentException
     */
    private function validate(array $setup): void
    {
        $this->validateKeyExists($setup, self::SETUP_KEY_OPTIONS);
        $this->validateKeyIsArray($setup, self::SETUP_KEY_OPTIONS);

        $this->validateKeyExists($setup, self::SETUP_KEY_GROUPS);
        $this->validateKeyIsArray($setup, self::SETUP_KEY_GROUPS);
    }

    /**
     * @param array $setup
     * @param string $key
     * @return void
     * @throws InvalidArgumentException
     */
    private function validateKeyExists(array $setup, string $key): void
    {
        // All fine if isset
        if (isset($setup[$key])) {
            return;
        }

        $message = sprintf(
            "The configuration file is missing the '%s' property.",
            $key
        );

        throw new InvalidArgumentException($message);
    }


    /**
     * @param array $setup
     * @param string $key
     * @return void
     * @throws InvalidArgumentException
     */
    private function validateKeyIsArray(array $setup, string $key): void
    {
        // All fine if is array
        if (is_array($setup[$key])) {
            return;
        }

        $message = sprintf(
            "The %s property must be an array.",
            $key
        );

        throw new InvalidArgumentException($message);
    }
}
