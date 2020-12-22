<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\Value\Option;

use IceCake\AppConfigurator\Common\Contract\OptionValueInterface;

/**
 * Description of BooleanType
 *
 * @author Wesley van den haak
 */
class BooleanType implements OptionValueInterface
{

    private bool $value;

    /**
     * @param bool $value
     */
    public function __construct(bool $value)
    {
        $this->setValue($value);
    }

    /**
     * @return bool
     */
    public function getValue(): bool
    {
        return $this->value;
    }

    /**
     * @param bool $value
     * @return void
     */
    private function setValue(bool $value): void
    {
        // @todo Add checks?

        $this->value = $value;
    }

}
