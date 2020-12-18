<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\Contract;

/**
 *
 * @author Wesley van den haak
 */
interface DataSourceInterface
{

    public function validate(): void;

    public function load(): array;
}
