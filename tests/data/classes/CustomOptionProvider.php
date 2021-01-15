<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\data\classes;

use Wvandenhaak\Configuration\Common\Contract\OptionProviderInterface;
Use Wvandenhaak\Configuration\Common\Contract\OptionValueInterface;
use Wvandenhaak\Configuration\Common\Value\Option\StringType;

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