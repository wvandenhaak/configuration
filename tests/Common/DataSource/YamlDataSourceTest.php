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

    /**
     * @return void
     */
    public function setup(): void
    {
        $filePath = $this->getMockBuilder(FilePathValue::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filePath->method('getValue')
            ->willReturn(dirname(dirname(__DIR__)) . '/data/files/test-configuration.yaml');

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
     * Test if the class can throw an exception
     * @return void
     */
    public function testThrowsLoadingException(): void
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

}
