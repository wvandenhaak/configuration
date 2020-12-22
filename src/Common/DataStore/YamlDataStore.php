<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\DataStore;

use IceCake\AppConfigurator\Common\Contract\DataStoreInterface;
use IceCake\AppConfigurator\Config\Model\Config;
use Symfony\Component\Yaml\Yaml;

/**
 * Description of YamlDataStore
 *
 * @author Wesley van den haak
 */
class YamlDataStore implements DataStoreInterface
{

    private string $folderPath;
    private string $filename;

    /**
     * @param string $folderPath
     * @param string $filename
     */
    public function __construct(
        string $folderPath,
        string $filename
    )
    {
        $this->folderPath = $folderPath;
        $this->filename = $filename;
    }

    /**
     * @param Config $config
     * @return void
     */
    public function save(Config $config): void
    {

        $fullFileName = $this->folderPath . DIRECTORY_SEPARATOR . $this->filename;
        // @todo check double or missing directory separators?
        
        // Create file contents
        $fileContents = Yaml::dump([
            DataStoreInterface::CONFIG_KEY => $config->getAll()
        ]);

        // Write file
        file_put_contents($fullFileName, $fileContents);
    }

}
