<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\Contract;

use IceCake\AppConfigurator\Config\Model\Config;

/**
 *
 * @author Wesley van den haak
 */
interface DataStoreInterface
{
    
    public const CONFIG_KEY = 'configuration';

    public function save(Config $config): void;
}
