<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Common\Value;

use InvalidArgumentException;
use Wvandenhaak\Configuration\Common\Value\FilePathValue;
use PHPUnit\Framework\TestCase;

class FilePathValueTest extends TestCase
{

    private string $testFilepath;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->testFilepath =  dirname(dirname(__DIR__)) . '/data/files/test-configuration.php';
    }

    /**
     * Test if the object can be created and returns the correct value without errors
     */
    public function testGetValue(): void
    {
        $subject = new FilePathValue($this->testFilepath);

        $this->assertEquals($this->testFilepath, $subject->getValue());
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
}
