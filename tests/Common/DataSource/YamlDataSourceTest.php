<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Common\DataSource;

use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Common\DataSource\YamlDataSource;
use Wvandenhaak\Configuration\Common\Exception\LoadingException;
use Wvandenhaak\Configuration\Common\Value\FilePathValue;

/**
 * Description of YamlDataSourceTest
 */
class YamlDataSourceTest extends TestCase
{

    private FilePathValue $filePath;
    private string $testFile;

    /**
     * @return void
     */
    public function setup(): void
    {
        $this->testFile = dirname(dirname(__DIR__)) . '/data/files/test-configuration.yaml';

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
        $dataSource = new YamlDataSource($this->filePath);

        $actual = $dataSource->load();
        $this->assertIsArray($actual);
    }

    /**
     * Test if the validation does not throw an error
     * @return void
     */
    public function testCanValidate(): void
    {
        $dataSource = new YamlDataSource($this->filePath);

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
            ->willReturn('path/to/not/existing/file.yaml');

        $dataSource = new YamlDataSource($filePath);
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

        $dataSource = new YamlDataSource($filePath);
        $dataSource->validate(); // First call
        $dataSource->load(); // Second call
    }

}
