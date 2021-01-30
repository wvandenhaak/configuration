<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Common\DataStore;

use Wvandenhaak\Configuration\Common\DataStore\ArrayDataStore;
use Wvandenhaak\Configuration\Common\DataStore\DataStoreFactory;
use Wvandenhaak\Configuration\Common\DataStore\YamlDataStore;
use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Common\Value\FilePathValue;

/**
 * Description of DataStoreFactoryTest
 *
 * @author Wesley van den haak
 */
class DataStoreFactoryTest extends TestCase
{

    private FilePathValue $filepathMock;
    private DataStoreFactory $subject;

    /**
     * @return void
     */
    public function setUp(): void
    {
        // PHP file type is not valid for some DataSource classes. Does not matter for testing
        $filepath = dirname(dirname(__DIR__)) . '/data/files/unittest-array-datastore.php';

        $filepathMock = $this->getMockBuilder(FilePathValue::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filepathMock->method('getValue')
            ->willReturn($filepath);

        $this->filepathMock = $filepathMock;

        $this->subject = new DataStoreFactory();
    }

    /**
     * Test if the factory can create an ArrayDataStore class
     * @return void
     */
    public function testCanCreateArrayDataStore(): void
    {
        $actual = $this->subject->createArrayDataStore($this->filepathMock);

        $this->assertInstanceOf(ArrayDataStore::class, $actual);
    }

    /**
     * Test if the factory can create an YamlDataStore class
     * @return void
     */
    public function testCanCreateYamlDataStore(): void
    {
        $actual = $this->subject->createYamlDataStore($this->filepathMock);

        $this->assertInstanceOf(YamlDataStore::class, $actual);

    }

}
