<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Config\Service\Writer\DataStore;

use IceCake\AppConfigurator\Config\Model\Config;
use IceCake\AppConfigurator\Config\Service\Writer\DataStore\YamlDataStore;
use PHPUnit\Framework\TestCase;

/**
 * Description of YamlDataStoreTest
 *
 * @author Wesley van den haak
 */
class YamlDataStoreTest extends TestCase
{

    private string $folder;
    private string $filename;
    private string $fullPath;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->filename = 'unittest-yaml-datastore.yaml';
        $this->folder = dirname(dirname(dirname(dirname(__DIR__)))) . '/data/files/';
        $this->fullPath = $this->folder . DIRECTORY_SEPARATOR . $this->filename;
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        // Clean up created file
        if (file_exists($this->fullPath)) {
            unlink($this->fullPath);
        }
    }

    /**
     * Test if the dataSource can save to the given location
     * @return void
     */
    public function testCanSave(): void
    {
        $config = $this->getMockBuilder(Config::class)
                ->disableOriginalConstructor()
                ->getMock();

        $config->expects($this->once())
                ->method('getAll')
                ->willReturn([]);

        $dataStore = new YamlDataStore($this->folder, $this->filename);
        $dataStore->save($config);

        $this->assertFileExists($this->fullPath);
    }
    
}
