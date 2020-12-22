<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup\Model\Option;

use IceCake\AppConfigurator\Common\Contract\OptionValueInterface;

/**
 * Description of Option
 *
 * @author Wesley van den haak
 */
class Option
{

    private string $key;
    private OptionValueInterface $value;
    private ?OptionValueInterface $default;
    
    /**
     * @param string $key
     * @param OptionValueInterface $value
     * @param OptionValueInterface|null $default
     */
    public function __construct(
        string $key,
        OptionValueInterface $value,
        ?OptionValueInterface $default
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
    public function getDefaultValue(): mixed
    {
        // Return NULL or value from object
        return $this->default?->getValue();
    }

}
