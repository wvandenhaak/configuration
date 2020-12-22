<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup\Model;

use IceCake\AppConfigurator\Setup\Model\Group\GroupCollection;
use IceCake\AppConfigurator\Setup\Model\Option\OptionCollection;

/**
 * Description of Setup
 *
 * @author Wesley van den haak
 */
class Setup
{

    private OptionCollection $options;
    private GroupCollection $groups;

    /**
     * @param OptionCollection $options
     * @param GroupCollection $groups
     */
    public function __construct(
        OptionCollection $options,
        GroupCollection $groups
    )
    {
        $this->options = $options;
        $this->groups = $groups;
    }

    /**
     * @return OptionCollection
     */
    public function getOptions(): OptionCollection
    {
        return $this->options;
    }

    /**
     * @return GroupCollection
     */
    public function getGroups(): GroupCollection
    {
        return $this->groups;
    }

}
