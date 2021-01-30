<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\DataStore;

use Wvandenhaak\Configuration\Common\DataStore\ArrayDataStore;
use Wvandenhaak\Configuration\Common\DataStore\YamlDataStore;
use Wvandenhaak\Configuration\Common\Value\FilePathValue;

/**
 * @author Wesley van den haak
 */
class DataStoreFactory
{

    /**
     * @param FilePathValue $filepath
     * @return ArrayDataStore
     */
    public function createArrayDataStore(FilePathValue $filepath): ArrayDataStore
    {
        return new ArrayDataStore($filepath);
    }

    /**
     * @param FilePathValue $filepath
     * @return YamlDataStore
     */
    public function createYamlDataStore(FilePathValue $filepath): YamlDataStore
    {
        return new YamlDataStore($filepath);
    }
}