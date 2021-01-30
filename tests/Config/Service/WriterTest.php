<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Config\Service;

use Exception;
use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Common\DataStore\ArrayDataStore;
use Wvandenhaak\Configuration\Common\Exception\WriteException;
use Wvandenhaak\Configuration\Config\Model\Config;
use Wvandenhaak\Configuration\Config\Service\Writer;

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
