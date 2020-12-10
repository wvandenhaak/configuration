<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Config\Contract;

/**
 *
 * @author Wesley van den haak
 */
interface DataSourceInterface
{

    public function validate(): void;

    public function load(): array;
}
