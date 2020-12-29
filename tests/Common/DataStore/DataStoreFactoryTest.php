<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Common\DataStore;

use IceCake\AppConfigurator\Common\DataStore\ArrayDataStore;
use IceCake\AppConfigurator\Common\DataStore\DataStoreFactory;
use IceCake\AppConfigurator\Common\DataStore\YamlDataStore;
use PHPUnit\Framework\TestCase;

/**
 * Description of DataStoreFactoryTest
 *
 * @author Wesley van den haak
 */
class DataStoreFactoryTest extends TestCase
{

    private string $folder;
    private string $filename;
    private DataStoreFactory $subject;

    /**
     * @return void
     */
    public function setUp(): void
    {
        // @todo make correct files. PHP file type is not valid for some DataSource classes
        $this->filename = 'unittest-array-datastore.php';
        $this->folder = dirname(dirname(__DIR__)) . '/data/files/';

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
