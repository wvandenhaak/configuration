<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Test\Service\Loader;

use IceCake\AppConfigurator\Exception\LoadingException;
use IceCake\AppConfigurator\Service\Loader\ArrayLoader;
use PHPUnit\Framework\TestCase;

/**
 * Description of ArrayLoaderTest
 *
 * @author Wesley van den haak
 */
class ArrayLoaderTest extends TestCase
{

    private ArrayLoader $subject;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->subject = new ArrayLoader();
    }

    /**
     * Test if the loader can load from a given file
     * @return void
     */
    public function testCanLoadFromFile(): void
    {

        $filename = dirname(dirname(__DIR__)) . '/data/files/test-configuration.php';

        $result = $this->subject->loadFromFile($filename);

        $this->assertIsArray($result);
    }

    /**
     * Test if the loader throws an LoadingException when a file cannot be found (or is not readable)
     * @return void
     */
    public function testThrowsLoadingException(): void
    {
        $this->expectException(LoadingException::class);

        $unknownFile = 'not_existing_file.php';

        $this->subject->loadFromFile($unknownFile);
    }

}
