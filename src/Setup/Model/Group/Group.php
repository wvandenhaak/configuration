<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup\Model\Group;

/**
 * Description of Group
 *
 * @author Wesley van den haak
 */
class Group
{

    private string $name;
    private array $keys;

    /**
     * @param string $name
     * @param array $keys
     */
    public function __construct(string $name, array $keys)
    {
        $this->name = $name;
        $this->keys = $keys;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getKeys(): array
    {
        return $this->keys;
    }

}
