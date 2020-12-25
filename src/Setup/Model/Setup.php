<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup\Model;

use IceCake\AppConfigurator\Common\Contract\ReadableConfigInterface;
use IceCake\AppConfigurator\Setup\Model\Group\GroupCollection;
use IceCake\AppConfigurator\Setup\Model\Option\OptionCollection;

/**
 * Description of Setup
 *
 * @author Wesley van den haak
 */
class Setup implements ReadableConfigInterface
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
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $this->options->findOption($key)?->getDefaultValue();
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
