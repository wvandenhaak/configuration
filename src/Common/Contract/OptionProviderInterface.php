<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\Contract;

use \IceCake\AppConfigurator\Common\Contract\OptionValueInterface;

/**
 *
 * @author Wesley van den haak
 */
interface OptionProviderInterface
{

    /**
     * @return array
     */
    public static function getChoices(): array;

    /**
     * @return OptionValueInterface|null
     */
    public static function getDefaultValue(): ?OptionValueInterface;
}