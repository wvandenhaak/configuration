<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\Value\Option;

use InvalidArgumentException;
use Wvandenhaak\Configuration\Common\Contract\OptionValueInterface;

/**
 * Description of StringType
 *
 * @author Wesley van den haak
 */
class StringType implements OptionValueInterface
{

    private string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->setValue($value);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return void
     * @throws InvalidArgumentException
     */
    private function setValue(string $value): void
    {
        if (empty($value)) {
            throw new InvalidArgumentException("Value cannot be empty.");
        }

        $this->value = $value;
    }

}
