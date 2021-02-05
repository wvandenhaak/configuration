<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\Value\Option;

use Wvandenhaak\Configuration\Common\Contract\OptionValueInterface;
use Wvandenhaak\Configuration\Common\Exception\InvalidArgumentException;

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
     * @param array $values
     * @return void
     * @throws InvalidArgumentException
     */
    private function setValue(array $values): void
    {
        foreach($values as $value) {
            // Multidimensional arrays are not supported
            if (is_array($value)) {
                throw new InvalidArgumentException('Array values are not supported.');
            }
        }

        $this->value = $values;
    }

}
