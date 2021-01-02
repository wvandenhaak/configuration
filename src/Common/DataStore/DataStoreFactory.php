<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\DataStore;

use IceCake\AppConfigurator\Common\DataStore\ArrayDataStore;
use IceCake\AppConfigurator\Common\DataStore\YamlDataStore;
use IceCake\AppConfigurator\Common\Value\File\FileNameValue;
use IceCake\AppConfigurator\Common\Value\File\FolderValue;

/**
 * @author Wesley van den haak
 */
class DataStoreFactory
{

    /**
     * @param FolderValue $folder
     * @param FileNameValue $filename
     * @return ArrayDataStore
     */
    public function createArrayDataStore(
        FolderValue $folder,
        FileNameValue $filename
    ): ArrayDataStore
    {
        return new ArrayDataStore($folder, $filename);
    }

    /**
     * @param FolderValue $folder
     * @param FileNameValue $filename
     * @return YamlDataStore
     */
    public function createYamlDataStore(
        FolderValue $folder,
        FileNameValue $filename
    ): YamlDataStore
    {
        return new YamlDataStore($folder, $filename);
    }
}