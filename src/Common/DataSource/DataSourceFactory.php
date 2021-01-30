<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\DataSource;

use Wvandenhaak\Configuration\Common\DataSource\ArrayDataSource;
use Wvandenhaak\Configuration\Common\DataSource\YamlDataSource;
use Wvandenhaak\Configuration\Common\Value\FilePathValue;

/**
 * An factory for creating datasources
 */
class DataSourceFactory
{

    /**
     * @param FilePathValue $filePath
     * @return ArrayDataSource
     */
    public function createArrayDataSource(FilePathValue $filePath): ArrayDataSource
    {
        return new ArrayDataSource($filePath);
    }

    /**
     * @param FilePathValue $filePath
     * @return YamlDataSource
     */
    public function createYamlDataSource(FilePathValue $filePath): YamlDataSource
    {
        return new YamlDataSource($filePath);
    }
}