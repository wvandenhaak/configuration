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

    public function save(Config $config): void;
}
