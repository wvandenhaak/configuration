<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Test\Common\Value;

use InvalidArgumentException;
use IceCake\AppConfigurator\Common\Value\FolderValue;
use PHPUnit\Framework\TestCase;

/**
 * Description of FolderValueTest
 *
 * @author Wesley van den haak
 */
class FolderValueTest extends TestCase
{
    
    /**
     * Test if the object can correctly format given values
     * 
     * @param string $folder
     * @param string $expected
     * @return void
     * 
     * @dataProvider valuesProvider
     */
    public function testGetValue(
        string $folder,
        string $expected
    ): void
    {
        $subject = new FolderValue($folder);
        
        $actual = $subject->getValue();
        $this->assertSame($expected, $actual);
    }
    
    /**
     * Test if an exception is thrown when an empty value is given
     * @return void
     */
    public function testThrowsExceptionOnEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        $value = new FolderValue('');
    }
    
    /**
     * @return array
     */
    public function valuesProvider(): array
    {
        return [
            // folder name, expected format
            ['simple/folder', 'simple/folder'],
            ['/simple/folder/', '/simple/folder'],
        ];
    }
}
