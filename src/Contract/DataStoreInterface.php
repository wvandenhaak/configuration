<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Contract;

use IceCake\AppConfigurator\Model\Config\Config;

/**
 *
 * @author Wesley van den haak
 */
interface DataStoreInterface
{
    
    public const CONFIG_KEY = 'configuration';
    
    public function __construct(Config $config, string $filename);

    public function save(string $folderPath): void;
}
