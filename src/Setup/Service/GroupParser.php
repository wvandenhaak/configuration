<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup\Service;

use InvalidArgumentException;
use IceCake\AppConfigurator\Setup\Model\Group\Group;
use IceCake\AppConfigurator\Setup\Model\Group\GroupCollection;
use IceCake\AppConfigurator\Setup\Model\Option\OptionCollection;

/**
 * Description of GroupParser
 *
 * @author Wesley van den haak
 */
class GroupParser
{

    private const KEY_NAME = 'name';
    private const KEY_KEYS = 'keys';

    /**
     * @param OptionCollection $options
     * @param array $groups
     * @return GroupCollection
     */
    public function parse(
        OptionCollection $options,
        array $groups
    ): GroupCollection
    {
        $collection = new GroupCollection();

        // Parse each group
        foreach ($groups as $group) {
            $this->validateGroup($group);

            $group = $this->parseGroup(
                $group[self::KEY_NAME],
                $group[self::KEY_KEYS],
                $options
            );

            $collection->append($group);
        }

        return $collection;
    }

    /**
     * @param string $name
     * @param array $keys
     * @param OptionCollection $optionCollection
     * @return Group
     */
    private function parseGroup(
        string $name,
        array $keys,
        OptionCollection $optionCollection
    ): Group
    {
        $options = new OptionCollection();

        foreach ($keys as $key) {
            $option = $optionCollection->findOption($key);

            if (!$option) {
                throw new InvalidArgumentException(sprintf(
                    "Option for key '%s' does not exist.",
                    $key
                ));
            }

            $options->append($option);
        }

        return new Group($name, $options);
    }

    /**
     * @param array $group
     * @return void
     * @throws InvalidArgumentException
     * @todo: Create separate validator class
     *
     */
    private function validateGroup(array $group): void
    {
        if (empty($group[self::KEY_NAME])) {
            throw new InvalidArgumentException("Group missing required 'name' key.");
        }

        if (empty($group[self::KEY_KEYS])) {
            throw new InvalidArgumentException("Group missing required 'keys' key.");
        }

        if (is_array($group[self::KEY_KEYS]) === false) {
            throw new InvalidArgumentException(sprintf(
                "Group '%s' is missing an array of keys.",
                $group[self::KEY_NAME]
            ));
        }
    }
}