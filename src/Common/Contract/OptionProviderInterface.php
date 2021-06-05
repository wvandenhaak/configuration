<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\Contract;

use Wvandenhaak\Configuration\Common\Contract\OptionValueInterface;

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