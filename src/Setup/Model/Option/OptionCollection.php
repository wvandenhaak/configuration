<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Setup\Model\Option;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use Wvandenhaak\Configuration\Setup\Model\Option\Option;

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
     * Find an Option by its key
     * @param string $key
     * @return Option|null
     */
    public function findOption(string $key): ?Option
    {
        foreach ($this->elements as $option) {
            if ($option->getKey() === $key) {
                return $option;
            }
        }

        return null;
    }

    /**
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }

}
