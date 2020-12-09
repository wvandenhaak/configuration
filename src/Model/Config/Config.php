<?php

declare(strict_types = 1);

namespace IceCake\AppConfigurator\Model\Config;

/**
 * The config is an object which holds multiple key-value pairs
 *
 * @author Wesley van den haak
 */
class Config
{

    /**
     * @param array $elements
     */
    public function __construct(
        private array $elements = []
    ) { 
    }

    /**
     * @param string $key
     * @retun mixed
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
