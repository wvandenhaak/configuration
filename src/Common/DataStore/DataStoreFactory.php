<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\DataStore;

use Wvandenhaak\Configuration\Common\DataStore\ArrayDataStore;
use Wvandenhaak\Configuration\Common\DataStore\YamlDataStore;
use Wvandenhaak\Configuration\Common\Value\File\FileNameValue;
use Wvandenhaak\Configuration\Common\Value\File\FolderValue;

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