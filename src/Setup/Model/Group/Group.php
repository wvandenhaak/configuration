<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup\Model\Group;

use IceCake\AppConfigurator\Setup\Model\Option\OptionCollection;

/**
 * Description of Group
 *
 * @author Wesley van den haak
 */
class Group
{

    private string $name;
    private OptionCollection $options;

    /**
     * @param string $name
     * @param OptionCollection $options
     */
    public function __construct(string $name, OptionCollection $options)
    {
        $this->name = $name;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return OptionCollection
     */
    public function getOptions(): OptionCollection
    {
        return $this->options;
    }

}
