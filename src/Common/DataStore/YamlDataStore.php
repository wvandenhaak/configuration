<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\DataStore;

use Wvandenhaak\Configuration\Common\Contract\DataStoreInterface;
use Wvandenhaak\Configuration\Common\Value\File\FileNameValue;
use Wvandenhaak\Configuration\Common\Value\File\FolderValue;
use Wvandenhaak\Configuration\Config\Model\Config;
use Symfony\Component\Yaml\Yaml;

/**
 * Description of YamlDataStore
 *
 * @author Wesley van den haak
 */
class YamlDataStore implements DataStoreInterface
{

    private FolderValue $folder;
    private FileNameValue $filename;

    /**
     * @param FolderValue $folder
     * @param FileNameValue $filename
     */
    public function __construct(
        FolderValue $folder,
        FileNameValue $filename
    )
    {
        $this->folder = $folder;
        $this->filename = $filename;
    }

    /**
     * @param Config $config
     * @return void
     */
    public function save(Config $config): void
    {
        $fullFileName = $this->folder->getValue() . DIRECTORY_SEPARATOR . $this->filename->getValue();

        // Create file contents
        $fileContents = Yaml::dump([
            Config::KEY => $config->getAll()
        ]);

        // Write file
        file_put_contents($fullFileName, $fileContents);
    }

}
