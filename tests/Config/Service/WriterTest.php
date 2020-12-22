<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Test\Config\Service;

use Exception;
use IceCake\AppConfigurator\Common\DataStore\ArrayDataStore;
use IceCake\AppConfigurator\Config\Exception\WriteException;
use IceCake\AppConfigurator\Config\Model\Config;
use IceCake\AppConfigurator\Config\Service\Writer;
use PHPUnit\Framework\TestCase;

/**
 * Description of WriterTest
 *
 * @author Wesley van den haak
 */
class WriterTest extends TestCase
{

    private Writer $subject;
    private Config $config;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->subject = new Writer();
        $this->config = $this->createMock(Config::class);
    }

    /**
     * Test if the writer can perform the save action on a datasource
     * @return void
     */
    public function testCanWrite(): void
    {

        $dataStore = $this->getMockBuilder(ArrayDataStore::class)
                ->disableOriginalConstructor()
                ->getMock();

        $dataStore->expects($this->once())
                ->method('save')
                ->with($this->equalTo($this->config));

        $this->subject->save($this->config, $dataStore);
    }

    /**
     * Test if the writer will throw an WriteException when writing fails
     * @return void
     */
    public function testWillThrowWriteException(): void
    {
        $this->expectException(WriteException::class);

        $dataStore = $this->getMockBuilder(ArrayDataStore::class)
                ->disableOriginalConstructor()
                ->getMock();

        $dataStore->expects($this->once())
                ->method('save')
                ->with($this->equalTo($this->config))
                ->willThrowException(new Exception());

        $this->subject->save($this->config, $dataStore);
    }

}
