<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Common\DataSource;

use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Common\DataSource\ArrayDataSource;
use Wvandenhaak\Configuration\Common\DataSource\DataSourceFactory;
use Wvandenhaak\Configuration\Common\DataSource\YamlDataSource;
use Wvandenhaak\Configuration\Common\Value\FilePathValue;

/**
 * Description of DataSourceFactoryTest
 */
class DataSourceFactoryTest extends TestCase
{

    private FilePathValue $filePath;
    private DataSourceFactory $subject;

    /**
     * @return void
     */
    public function setup(): void
    {
        $this->filePath = $this->getMockBuilder(FilePathValue::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subject = new DataSourceFactory();
    }

    /**
     * Test if the factory can create an ArrayDataSource class
     * @return void
     */
    public function testCanCreateArrayDataSource(): void
    {
        $actual = $this->subject->createArrayDataSource($this->filePath);

        $this->assertInstanceOf(ArrayDataSource::class, $actual);
    }

    /**
     * Test if the factory can create an YamlDataSource class
     * @return void
     */
    public function testCanCreateYamlDataSource(): void
    {
        $actual = $this->subject->createYamlDataSource($this->filePath);

        $this->assertInstanceOf(YamlDataSource::class, $actual);
    }

}
