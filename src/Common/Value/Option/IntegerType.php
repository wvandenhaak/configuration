<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\Value\Option;

use IceCake\AppConfigurator\Common\Contract\OptionValueInterface;

/**
 * Description of IntegerType
 *
 * @author Wesley van den haak
 */
class IntegerType implements OptionValueInterface
{
    
    private int $value;
    
    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->setValue($value);
    }
    
    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     * @return void
     */
    private function setValue(int $value): void
    {
        // @todo Add checks?

        $this->value = $value;
    }

}
