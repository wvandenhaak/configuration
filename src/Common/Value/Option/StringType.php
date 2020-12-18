<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\Value\Option;

use InvalidArgumentException;
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
            $message = "Value cannot be empty.";
            throw new InvalidArgumentException($message);
        }

        $this->value = $value;
    }

}
