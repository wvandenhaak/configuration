<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\data\classes;

use IceCake\AppConfigurator\Common\Contract\OptionProviderInterface;
Use IceCake\AppConfigurator\Common\Contract\OptionValueInterface;
use IceCake\AppConfigurator\Common\Value\Option\StringType;

/**
 * @author Wesley van den haak
 */
class CustomOptionProvider implements OptionProviderInterface
{

    /**
     * @return array
     */
    public static function getChoices(): array
    {
        return [
            "custom option 1",
            "custom option 2",
            "custom option 3",
            "custom option 4",
            "custom option 5",
        ];
    }

    /**
     * @return OptionValueInterface|null
     */
    public static function getDefaultValue(): ?OptionValueInterface
    {
        return new StringType("custom option 3");
    }
}