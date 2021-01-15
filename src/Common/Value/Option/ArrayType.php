<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\Value\Option;

use Wvandenhaak\Configuration\Common\Contract\OptionValueInterface;

/**
 * Description of ArrayType
 *
 * @author Wesley van den haak
 */
class ArrayType implements OptionValueInterface
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
