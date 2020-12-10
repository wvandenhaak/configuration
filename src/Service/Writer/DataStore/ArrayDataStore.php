<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Service\Writer\DataStore;

use Exception;
use IceCake\AppConfigurator\Contract\DataStoreInterface;
use IceCake\AppConfigurator\Exception\WriteException;
use IceCake\AppConfigurator\Model\Config\Config;

/**
 * Description of ArrayDataStore
 *
 * @author Wesley van den haak
 */
class ArrayDataStore implements DataStoreInterface
{

    private Config $config;
    private string $filename;

    /**
     * @param Config $config
     * @param string $filename
     */
    public function __construct(
        Config $config,
        string $filename
    )
    {
        $this->config = $config;
        $this->filename = $filename;
    }

    /**
     * @param string $folderPath
     * @return void
     */
    public function save(string $folderPath): void
    {

        $fullFileName = $folderPath . DIRECTORY_SEPARATOR . $this->filename;
        // @todo check double or missing directory separators?
        
        // Create file contents
        $configData = $this->config->getAll();
        $data = [DataStoreInterface::CONFIG_KEY => $configData];
        
        $fileContents = "<?php\n\nreturn " . var_export($data, true) . "\n\n?>";
        
        // Write file
        $handle = fopen($fullFileName, 'w+');
        fwrite($handle, $fileContents);
        fclose($handle);
    }

}
