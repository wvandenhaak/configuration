<?php

namespace IceCake\AppConfigurator\Contract;

/**
 *
 * @author Wesley van den haak
 */
interface DataSourceInterface
{

    public function validate(): void;

    public function load(): array;
}
