<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\Contract;

/**
 *
 * @author Wesley van den haak
 */
interface ReadableConfigInterface
{

    public function get(string $key): mixed;
}
