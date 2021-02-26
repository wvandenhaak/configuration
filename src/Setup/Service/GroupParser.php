<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Setup\Service;

use Wvandenhaak\Configuration\Common\Enum\GroupEnum;
use Wvandenhaak\Configuration\Common\Exception\ParseException;
use Wvandenhaak\Configuration\Setup\Model\Group\Group;
use Wvandenhaak\Configuration\Setup\Model\Group\GroupCollection;
use Wvandenhaak\Configuration\Setup\Model\Option\OptionCollection;
use Wvandenhaak\Configuration\Setup\Service\GroupValidator;

/**
 * Description of GroupParser
 */
class GroupParser
{

    private GroupValidator $validator;

    /**
     * @param GroupValidator $validator
     */
    public function __construct(GroupValidator $validator)
    {
        $this->validator = $validator;
    }

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
            $this->validator->validateGroup($group);

            $group = $this->parseGroup(
                $group[GroupEnum::KEY_NAME],
                $group[GroupEnum::KEY_KEYS],
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
     * @throws ParseException
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
                throw new ParseException(sprintf(
                    "Option for key '%s' does not exist.",
                    $key
                ));
            }

            $options->append($option);
        }

        return new Group($name, $options);
    }
}