<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Common\DataStore;

use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Common\DataStore\ArrayDataStore;
use Wvandenhaak\Configuration\Common\Value\FilePathValue;
use Wvandenhaak\Configuration\Config\Model\Config;

/**
 * Description of ArrayDataStoreTest
 *
 * @author Wesley van den haak
 */
class ArrayDataStoreTest extends TestCase
{

    private FilePathValue $filepathMock;
    private string $filepath;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->filepath = dirname(dirname(__DIR__)) . '/data/files/unittest-array-datastore.php';

        $filepathMock = $this->getMockBuilder(FilePathValue::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filepathMock->method('getValue')
            ->willReturn($this->filepath);

        $this->filepathMock = $filepathMock;
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        // Clean up created file
        if (file_exists($this->filepath)) {
            unlink($this->filepath);
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

        $dataStore = new ArrayDataStore($this->filepathMock);
        $dataStore->save($config);

        $this->assertFileExists($this->filepath);
    }

}
