<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\Value\Option;

use IceCake\AppConfigurator\Common\Contract\OptionTypeInterface;

/**
 * Description of ArrayType
 *
 * @author Wesley van den haak
 */
class ArrayType implements OptionTypeInterface
{

    private array $value;

    /**
     * @param array $value
     */
    public function __construct(array $value)
    {
        $this->setValue($value);
    }

    /**
     * @return array
     */
    public function getValue(): array
    {
        return $this->value;
    }

    /**
     * @param array $value
     * @return void
     */
    private function setValue(array $value): void
    {
        // @todo Add checks?

        $this->value = $value;
    }

}
