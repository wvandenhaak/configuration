<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Test\Common\DataSource;

use IceCake\AppConfigurator\Common\DataSource\YamlDataSource;
use IceCake\AppConfigurator\Config\Exception\LoadingException;
use PHPUnit\Framework\TestCase;

/**
 * Description of YamlDataSourceTest
 *
 * @author Wesley van den haak
 */
class YamlDataSourceTest extends TestCase
{

    private string $filename;

    /**
     * @return void
     */
    public function setup(): void
    {
        $this->filename = dirname(dirname(__DIR__)) . '/data/files/test-configuration.yaml';
    }

    /**
     * Test if the DataSource can load
     * @return void
     */
    public function testCanLoad(): void
    {
        $dataSource = new YamlDataSource($this->filename);

        $actual = $dataSource->load();
        $this->assertIsArray($actual);
    }

    /**
     * Test if the validation does not throw an error
     * @return void
     */
    public function testCanValidate(): void
    {

        $dataSource = new YamlDataSource($this->filename);

        $this->assertNull($dataSource->validate());
    }

    /**
     * Test if the class can throw an exception
     * @return void
     */
    public function testThrowsLoadingException(): void
    {
        $this->expectException(LoadingException::class);

        $nonExcistingFile = dirname(dirname(dirname(dirname(__DIR__)))) . '/data/files/non-existing-file.yaml';

        $dataSource = new YamlDataSource($nonExcistingFile);
        $dataSource->validate();
    }

}
