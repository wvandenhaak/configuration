<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\DataStore;

use Wvandenhaak\Configuration\Common\Contract\DataStoreInterface;
use Wvandenhaak\Configuration\Common\Enum\ConfigEnum;
use Wvandenhaak\Configuration\Common\Value\FilePathValue;
use Wvandenhaak\Configuration\Config\Model\Config;

/**
 * Description of ArrayDataStore
 *
 * @author Wesley van den haak
 */
class ArrayDataStore implements DataStoreInterface
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
        $configData = $config->getAll();
        $data = [ConfigEnum::KEY => $configData];

        $fileContents = "<?php\n\nreturn " . var_export($data, true) . "\n\n?>";

        // Write file
        file_put_contents($this->filePath->getValue(), $fileContents);
    }

}
