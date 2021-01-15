<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\DataSource;

use Wvandenhaak\Configuration\Common\DataSource\ArrayDataSource;
use Wvandenhaak\Configuration\Common\DataSource\YamlDataSource;

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