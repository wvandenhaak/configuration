<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\Value\Option;

use IceCake\AppConfigurator\Common\Contract\OptionTypeInterface;

/**
 * Description of IntegerType
 *
 * @author Wesley van den haak
 */
class IntegerType implements OptionTypeInterface
{
    
    private int $value;
    
    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }
    
    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}
