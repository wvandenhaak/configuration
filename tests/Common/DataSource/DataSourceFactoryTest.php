<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Common\DataSource;

use IceCake\AppConfigurator\Common\DataSource\ArrayDataSource;
use IceCake\AppConfigurator\Common\DataSource\DataSourceFactory;
use IceCake\AppConfigurator\Common\DataSource\YamlDataSource;
use PHPUnit\Framework\TestCase;

/**
 * Description of DataSourceFactoryTest
 *
 * @author Wesley van den haak
 */
class DataSourceFactoryTest extends TestCase
{

    private string $filename;
    private DataSourceFactory $subject;

    /**
     * @return void
     */
    public function setup(): void
    {
        // @todo make correct files. PHP file type is not valid for some DataSource classes
        $this->filename = dirname(dirname(__DIR__)) . '/data/files/test-configuration.php';

        $this->subject = new DataSourceFactory();
    }

    /**
     * Test if the factory can create an ArrayDataSource class
     * @return void
     */
    public function testCanCreateArrayDataSource(): void
    {
        $actual = $this->subject->createArrayDataSource($this->filename);

        $this->assertInstanceOf(ArrayDataSource::class, $actual);
    }

    /**
     * Test if the factory can create an YamlDataSource class
     * @return void
     */
    public function testCanCreateYamlDataSource(): void
    {
        $actual = $this->subject->createYamlDataSource($this->filename);

        $this->assertInstanceOf(YamlDataSource::class, $actual);
    }

}
