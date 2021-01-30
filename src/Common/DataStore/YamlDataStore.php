<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\DataStore;

use Wvandenhaak\Configuration\Common\Contract\DataStoreInterface;
use Wvandenhaak\Configuration\Common\Value\FilePathValue;
use Wvandenhaak\Configuration\Config\Model\Config;
use Symfony\Component\Yaml\Yaml;

/**
 * Description of YamlDataStore
 *
 * @author Wesley van den haak
 */
class YamlDataStore implements DataStoreInterface
{

    private FilePathValue $filePath;

    /**
     * @param FilePathValue $filePath
     */
    public function __construct(FilePathValue $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @param Config $config
     * @return void
     */
    public function save(Config $config): void
    {
        // Create file contents
        $fileContents = Yaml::dump([
            Config::KEY => $config->getAll()
        ]);

        // Write file
        file_put_contents($this->filePath->getValue(), $fileContents);
    }

}
