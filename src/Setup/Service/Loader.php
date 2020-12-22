<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup\Service;

use InvalidArgumentException;
use IceCake\AppConfigurator\Common\DataSource\YamlDataSource;
use IceCake\AppConfigurator\Setup\Model\Group\Group;
use IceCake\AppConfigurator\Setup\Model\Group\GroupCollection;
use IceCake\AppConfigurator\Setup\Model\Option\Option;
use IceCake\AppConfigurator\Setup\Model\Option\OptionCollection;
use IceCake\AppConfigurator\Setup\Model\Setup;

/**
 * Description of Loader
 *
 * @author Wesley van den haak
 */
class Loader
{

    /**
     * @param YamlDataSource $dataSource
     * @return Setup
     */
    public function load(YamlDataSource $dataSource): Setup
    {
        // Load
        $dataSource->validate();
        $setupArray = $dataSource->load();

        // @todo validate $setupArray

        $options = $this->parseOptions($setupArray['options']);
        $groups = $this->parseGroups($options, $setupArray['groups']);

        return new Setup($options, $groups);
    }

    /**
     * @param array $options
     * @return OptionCollection
     */
    private function parseOptions(array $options): OptionCollection
    {
        $collection = new OptionCollection();

        // Parse each option
        foreach ($options as $optionSettings) {
            $collection->append(
                $this->parseOption($optionSettings)
            );
        }

        return $collection;
    }

    /**
     * @param array $option
     * @return Option
     */
    private function parseOption(array $option): Option
    {
        $this->validateOption($option);

        // Create new object based on given type and inject value
        $typeClassname = $option['type'];
        $value = new $typeClassname($option['value']);

        // Default is null. If a value is give parse it into a Value object to
        // enforce same basic value (e.g. both int or string)
        $default = null;
        if (!empty($option['default'])) {
            $default = new $typeClassname($option['default']);
        }

        return new Option(
            $option['key'],
            $value,
            $default
        );
    }

    /**
     * @param array $option
     * @return void
     * @throws InvalidArgumentException
     * @todo: Create separate validator class
     *
     */
    private function validateOption(array $option): void
    {

        // Check if option has a value key and the contents are not empty.
        if (empty($option['key'])) {
            throw new InvalidArgumentException("Option missing required key property.");
        }

        // Check if an valid option type class is given
        if (empty($option['type']) || class_exists($option['type']) === false) {
            $message = sprintf(
                "Option type class %s does not exist.",
                $option['type']
            );

            throw new InvalidArgumentException($message);
        }

        // Check if option has a value key and the contents are not empty.
        // @todo: check not empty (note: boolean values are allowed)
        if (isset($option['value']) === false) {
            $message = sprintf(
                "Value for option with key %s may not be empty.",
                $option['key']
            );

            throw new InvalidArgumentException($message);
        }
    }

    /**
     * @param OptionCollection $options
     * @param array $groups
     * @return GroupCollection
     */
    private function parseGroups(OptionCollection $options, array $groups): GroupCollection
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
