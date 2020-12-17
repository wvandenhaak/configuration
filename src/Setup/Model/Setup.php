<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup\Model;

use IceCake\AppConfigurator\Setup\Model\Option\OptionCollection;

/**
 * Description of Setup
 *
 * @author Wesley van den haak
 */
class Setup
{

    private OptionCollection $options;

    /**
     * @param OptionCollection $options
     */
    public function __construct(OptionCollection $options)
    {
        $this->options = $options;
    }

}
