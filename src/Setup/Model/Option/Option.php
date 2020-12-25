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
    private array $choices;
    private ?OptionValueInterface $default;
    
    /**
     * @param string $key
     * @param OptionValueInterface|null $default
     * @param array $choices;
     */
    public function __construct(
        string $key,
        ?OptionValueInterface $default,
        array $choices
    )
    {
        $this->key = $key;
        $this->default = $default;
        $this->choices = $choices;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return array
     */
    public function getChoices(): array
    {
        return $this->choices;
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
