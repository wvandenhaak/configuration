<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\Value\Option;

use IceCake\AppConfigurator\Common\Contract\OptionTypeInterface;

/**
 * Description of BooleanType
 *
 * @author Wesley van den haak
 */
class BooleanType implements OptionTypeInterface
{
    
    private bool $value;
    
    /**
     * @param bool $value
     */
    public function __construct(bool $value)
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
