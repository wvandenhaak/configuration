<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Config\Model;

use Wvandenhaak\Configuration\Common\Contract\ReadableConfigInterface;

/**
 * The config is an object which holds multiple key-value pairs
 *
 * @author Wesley van den haak
 */
class Config implements ReadableConfigInterface
{

    private array $elements;

    /**
     * @param array $elements
     */
    public function __construct(array $elements = [])
    {
        $this->elements = $elements;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $this->elements[$key] ?? null;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->elements;
    }

}
