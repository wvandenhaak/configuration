<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Common\DataStore;

use IceCake\AppConfigurator\Common\DataStore\ArrayDataStore;
use IceCake\AppConfigurator\Common\DataStore\DataStoreFactory;
use IceCake\AppConfigurator\Common\DataStore\YamlDataStore;
use IceCake\AppConfigurator\Common\Value\File\FileNameValue;
use IceCake\AppConfigurator\Common\Value\File\FolderValue;
use PHPUnit\Framework\TestCase;

/**
 * Description of DataStoreFactoryTest
 *
 * @author Wesley van den haak
 */
class DataStoreFactoryTest extends TestCase
{

    private FolderValue $folder;
    private FileNameValue $filename;
    private DataStoreFactory $subject;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $filename = $this->createMock(FileNameValue::class);
        $filename->method('getValue')
            ->willReturn('unittest-array-datastore.php'); // PHP file type is not valid for some DataSource classes. Does not matter for testing

        $folder = $this->createMock(FolderValue::class);
        $folder->method('getValue')
            ->willReturn(dirname(dirname(__DIR__)) . '/data/files/');

        $this->folder = $folder;
        $this->filename = $filename;

        $this->subject = new DataStoreFactory();
    }

    /**
     * Test if the factory can create an ArrayDataStore class
     * @return void
     */
    public function testCanCreateArrayDataStore(): void
    {
        $actual = $this->subject->createArrayDataStore($this->folder, $this->filename);

        $this->assertInstanceOf(ArrayDataStore::class, $actual);
    }

    /**
     * Test if the factory can create an YamlDataStore class
     * @return void
     */
    public function testCanCreateYamlDataStore(): void
    {
        $actual = $this->subject->createYamlDataStore($this->folder, $this->filename);

        $this->assertInstanceOf(YamlDataStore::class, $actual);

    }

}
