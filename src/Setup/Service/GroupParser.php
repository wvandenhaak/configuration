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
                $group['name'],
                $group['keys'],
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
                $message = sprintf(
                    "Option for key '%s' does not exist.",
                    $key
                );

                throw new InvalidArgumentException($message);
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
        if (empty($group['name'])) {
            throw new InvalidArgumentException('Name of the group is required.');
        }

        if (isset($group['keys']) === false || is_array($group['keys']) === false) {
            $message = sprintf(
                "Group '%s' is missing an array of keys.",
                $group['name']
            );

            throw new InvalidArgumentException($message);
        }
    }
}