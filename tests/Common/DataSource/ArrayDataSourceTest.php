<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Common\DataSource;

use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Common\DataSource\ArrayDataSource;
use Wvandenhaak\Configuration\Common\Exception\LoadingException;
use Wvandenhaak\Configuration\Common\Value\FilePathValue;

/**
 * Description of ArrayDataSourceTest
 */
class ArrayDataSourceTest extends TestCase
{

    private FilePathValue $filePath;
    private string $testFile;

    /**
     * @return void
     */
    public function setup(): void
    {
        $this->testFile = dirname(dirname(__DIR__)) . '/data/files/test-configuration.php';

        $filePath = $this->getMockBuilder(FilePathValue::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filePath->method('getValue')
            ->willReturn($this->testFile);

        $this->filePath = $filePath;
    }

    /**
     * Test if the DataSource can load
     * @return void
     */
    public function testCanLoad(): void
    {
        $dataSource = new ArrayDataSource($this->filePath);

        $actual = $dataSource->load();
        $this->assertIsArray($actual);
    }

    /**
     * Test if the validation does not throw an error
     * @return void
     */
    public function testCanValidate(): void
    {
        $dataSource = new ArrayDataSource($this->filePath);

        $this->assertNull($dataSource->validate());
    }

    /**
     * Test if the class throws a LoadingException when a non-existing file is given
     * @return void
     */
    public function testThrowsLoadingExceptionOnNonExistingFile(): void
    {
        $this->expectException(LoadingException::class);

        $filePath = $this->getMockBuilder(FilePathValue::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filePath->method('getValue')
            ->willReturn('path/to/not/existing/file.php');

        $dataSource = new ArrayDataSource($filePath);
        $dataSource->validate();
    }

    /**
     * Test if the class throws a LoadingException when a problem occurs when loading
     * @return void
     */
    public function testThrowsLoadingExceptionOnLoad(): void
    {
        $this->expectException(LoadingException::class);

        $filePath = $this->getMockBuilder(FilePathValue::class)
            ->disableOriginalConstructor()
            ->getMock();

        // The method getValue will be called twice.
        // First time return the path. Second time return random, invalid, string.
        $filePath
            ->method('getValue')
            ->will(
                $this->onConsecutiveCalls(
                    $this->testFile, // First call
                    'random_string' // Second call
                )
            );

        $dataSource = new ArrayDataSource($filePath);
        $dataSource->validate(); // First call
        $dataSource->load(); // Second call
    }

}
