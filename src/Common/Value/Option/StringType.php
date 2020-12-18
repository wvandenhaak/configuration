<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\Value\Option;

use IceCake\AppConfigurator\Common\Contract\OptionTypeInterface;

/**
 * Description of StringType
 *
 * @author Wesley van den haak
 */
class StringType implements OptionTypeInterface
{
    
    private string $value;
    
    /**
     * @param string $value
     */
    public function __construct(string $value)
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
