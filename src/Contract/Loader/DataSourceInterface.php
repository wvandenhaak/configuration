<?php

namespace IceCake\AppConfigurator\Contract\Loader;

/**
 *
 * @author Wesley van den haak
 */
interface DataSourceInterface
{

    public function validate(): void;

    public function load(): array;
}
