<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Common\Value;

use InvalidArgumentException;
use Wvandenhaak\Configuration\Common\Value\FilePathValue;
use PHPUnit\Framework\TestCase;

class FilePathValueTest extends TestCase
{

    /**
     * Test if the object can be created and returns the correct value without errors
     * @dataProvider dataProviderGetValue
     *
     * @param string $filepath
     */
    public function testGetValue(string $filepath): void
    {
        $subject = new FilePathValue($filepath);

        $this->assertEquals($filepath, $subject->getValue());
    }

    /**
     * @return void
     */
    public function testThrowsExceptionOnEmptyFilePath(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new FilePathValue('');
    }

    /**
     * @return void
     */
    public function testThrowsExceptionOnMissingFilename(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new FilePathValue('/path/to/file/.txt');
    }

    /**
     * @return void
     */
    public function testThrowsExceptionOnMissingFileExtension(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new FilePathValue('/path/to/file/filename');
    }

    /**
     * @return array
     */
    public function dataProviderGetValue(): array
    {
        return [
            'Path with file and extension' =>       ['path/to/file/filename.txt'],
            'Only a file and extension' =>          ['filename.txt']
        ];
    }
}
