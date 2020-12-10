<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Test\Service\Writer;

use Exception;
use IceCake\AppConfigurator\Exception\WriteException;
use IceCake\AppConfigurator\Service\Writer\{
    DataStore\ArrayDataStore,
    Writer
};
use PHPUnit\Framework\TestCase;

/**
 * Description of WriterTest
 *
 * @author Wesley van den haak
 */
class WriterTest extends TestCase
{

    private string $folder;
    private Writer $subject;
    
    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->folder = 'fake/directory';

        $this->subject = new Writer($this->folder);
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
                ->with($this->equalTo($this->folder));
        
        $this->subject->save($dataStore);
        
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
                ->with($this->equalTo($this->folder))
                ->willThrowException(new Exception());
        
        $this->subject->save($dataStore);
    }
}
