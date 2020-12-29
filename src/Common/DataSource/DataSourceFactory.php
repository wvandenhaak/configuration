<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\DataSource;

use IceCake\AppConfigurator\Common\DataSource\ArrayDataSource;
use IceCake\AppConfigurator\Common\DataSource\YamlDataSource;

/**
 * @author Wesley van den haak
 */
class DataSourceFactory
{

    /**
     * @param string $filename
     * @return ArrayDataSource
     */
    public function createArrayDataSource(string $filename): ArrayDataSource
    {
        return new ArrayDataSource($filename);
    }

    /**
     * @param string $filename
     * @return YamlDataSource
     */
    public function createYamlDataSource(string $filename): YamlDataSource
    {
        return new YamlDataSource($filename);
    }
}