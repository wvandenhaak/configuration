<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup\Model\Group;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use IceCake\AppConfigurator\Setup\Model\Group\Group;

/**
 * A collection of multiple Group objects
 *
 * @author Wesley van den haak
 */
class GroupCollection implements IteratorAggregate, Countable
{

    private array $elements;

    public function __construct()
    {
        $this->elements = [];
    }

    /**
     * @param Group $group
     * @return self
     */
    public function append(Group $group): self
    {
        $this->elements[] = $group;
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
