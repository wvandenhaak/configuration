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
