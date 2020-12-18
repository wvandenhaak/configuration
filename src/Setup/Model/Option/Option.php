<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup\Model\Option;

use IceCake\AppConfigurator\Common\Contract\OptionTypeInterface;

/**
 * Description of Option
 *
 * @author Wesley van den haak
 */
class Option
{

    private string $key;
    private OptionTypeInterface $value;
    private mixed $default;
    
    /**
     * @param string $key
     * @param OptionTypeInterface $value
     * @param mixed $default
     */
    public function __construct(
        string $key,
        OptionTypeInterface $value,
        mixed $default
    )
    {
        $this->key = $key;
        $this->value = $value;
        $this->default = $default;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value->getValue();
    }

    /**
     * @return mixed
     */
    public function getDefault(): mixed
    {
        return $this->default;
    }

}
