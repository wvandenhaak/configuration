<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Setup\Service;

use Wvandenhaak\Configuration\Common\Contract\DataSourceInterface;
use Wvandenhaak\Configuration\Common\Exception\InvalidArgumentException;
use Wvandenhaak\Configuration\Config\Model\Config;
use Wvandenhaak\Configuration\Setup\Model\Setup;
use Wvandenhaak\Configuration\Setup\Service\GroupParser;
use Wvandenhaak\Configuration\Setup\Service\OptionParser;

/**
 * Description of Loader
 *
 * @author Wesley van den haak
 */
class Loader
{
    private const KEY_OPTIONS = 'options';
    private const KEY_GROUPS = 'groups';
    private const KEY_SETUP = 'setup';

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
        $options = $this->optionParser->parse($setup[self::KEY_SETUP][self::KEY_OPTIONS]);
        $groups = $this->groupParser->parse($options, $setup[self::KEY_SETUP][self::KEY_GROUPS]);

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
        $this->validateKeyExists($setup, self::KEY_SETUP);

        $this->validateKeyExists($setup[self::KEY_SETUP], self::KEY_OPTIONS);
        $this->validateKeyIsArray($setup[self::KEY_SETUP], self::KEY_OPTIONS);

        $this->validateKeyExists($setup[self::KEY_SETUP], self::KEY_GROUPS);
        $this->validateKeyIsArray($setup[self::KEY_SETUP], self::KEY_GROUPS);
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

        throw new InvalidArgumentException(sprintf(
            "The configuration file is missing the '%s' property.",
            $key
        ));
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

        throw new InvalidArgumentException(sprintf(
            "The %s property must be an array.",
            $key
        ));
    }
}
