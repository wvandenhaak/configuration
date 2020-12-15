<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Test\Common\Value;

use InvalidArgumentException;
use IceCake\AppConfigurator\Common\Value\FileNameValue;
use PHPUnit\Framework\TestCase;

/**
 * Description of FileNameValueTest
 *
 * @author Wesley van den haak
 */
class FileNameValueTest extends TestCase
{
    
    /**
     * Test if the object can correctly format given values
     * 
     * @param string $name
     * @param string $extension
     * @param string $expected
     * @return void
     * 
     * @dataProvider valuesProvider
     */
    public function testGetValue(
        string $name,
        string $extension,
        string $expected
    ): void
    {
        $subject = new FileNameValue($name, $extension);
        
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
        
        $value = new FileNameValue('', '.php');
    }
    
    /**
     * Test if an exception is thrown when the name could not be parsed correctly
     * @return void
     */
    public function testThrowsExceptionOnInvalidName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        $value = new FileNameValue('folder_name/.html', '.php');
    }
    
    /**
     * Test if an exception is thrown when an empty value is given
     * @return void
     */
    public function testThrowsExceptionOnEmptyExtension(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        $value = new FileNameValue('simple_name', '');
    }
    
    /**
     * @return array
     */
    public function valuesProvider(): array
    {
        return [
            // name, extension, expected format
            ['simple_name', 'js', 'simple_name.js'],
            ['script', '.php', 'script.php'],
            ['script.html', 'php', 'script.php'],
            ['/folder1/folder2/script.php', 'php', 'script.php']
        ];
    }
}
