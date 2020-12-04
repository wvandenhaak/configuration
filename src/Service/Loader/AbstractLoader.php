<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Service\Loader;

/**
 * Description of Loader
 *
 * @author Wesley van den haak
 */
abstract class AbstractLoader
{

    abstract public function loadFromFile(string $filepath): array;
}
