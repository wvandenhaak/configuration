<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\DataStore;

use IceCake\AppConfigurator\Common\DataStore\ArrayDataStore;
use IceCake\AppConfigurator\Common\DataStore\YamlDataStore;

/**
 * @author Wesley van den haak
 */
class DataStoreFactory
{

    /**
     * @param string $folderPath
     * @param string $filename
     * @return ArrayDataStore
     */
    public function createArrayDataStore(
        string $folderPath,
        string $filename
    ): ArrayDataStore
    {
        return new ArrayDataStore($folderPath, $filename);
    }

    /**
     * @param string $folderPath
     * @param string $filename
     * @return YamlDataStore
     */
    public function createYamlDataStore(
        string $folderPath,
        string $filename
    ): YamlDataStore
    {
        return new YamlDataStore($folderPath, $filename);
    }
}