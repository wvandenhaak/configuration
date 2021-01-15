<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\Contract;

use Wvandenhaak\Configuration\Config\Model\Config;

/**
 *
 * @author Wesley van den haak
 */
interface DataStoreInterface
{

    public function save(Config $config): void;
}
