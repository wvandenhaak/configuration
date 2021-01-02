<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Common\DataStore;

use IceCake\AppConfigurator\Common\DataStore\ArrayDataStore;
use IceCake\AppConfigurator\Common\Value\File\FileNameValue;
use IceCake\AppConfigurator\Common\Value\File\FolderValue;
use IceCake\AppConfigurator\Config\Model\Config;
use PHPUnit\Framework\TestCase;

/**
 * Description of ArrayDataStoreTest
 *
 * @author Wesley van den haak
 */
class ArrayDataStoreTest extends TestCase
{

    private FolderValue $folder;
    private FileNameValue $filename;
    private string $fullPath;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $filename = $this->createMock(FileNameValue::class);
        $filename->method('getValue')
            ->willReturn('unittest-array-datastore.php');

        $folder = $this->createMock(FolderValue::class);
        $folder->method('getValue')
            ->willReturn(dirname(dirname(__DIR__)) . '/data/files/');

        $this->folder = $folder;
        $this->filename = $filename;
        $this->fullPath = $this->folder->getValue() . DIRECTORY_SEPARATOR . $this->filename->getValue();
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

        $dataStore = new ArrayDataStore($this->folder, $this->filename);
        $dataStore->save($config);

        $this->assertFileExists($this->fullPath);
    }

}
