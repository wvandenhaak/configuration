<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\Contract;

/**
 *
 * @author Wesley van den haak
 */
interface DataSourceInterface
{

    public function validate(): void;

    public function load(): array;
}
