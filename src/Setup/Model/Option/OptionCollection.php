<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup\Model\Option;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use IceCake\AppConfigurator\Model\Setup\Option;

/**
 * A collection of multiple Option objects
 *
 * @author Wesley van den haak
 */
class OptionCollection implements IteratorAggregate, Countable
{

    private array $elements;

    public function __construct()
    {
        $this->elements = [];
    }

    /**
     * @param Option $option
     * @return self
     */
    public function append(Option $option): self
    {
        $this->elements[] = $option;
        return $this;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->elements);
    }

    /**
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }

}
