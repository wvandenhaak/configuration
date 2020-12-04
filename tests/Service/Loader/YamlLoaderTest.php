<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Test\Service\Loader;

use IceCake\AppConfigurator\Exception\LoadingException;
use IceCake\AppConfigurator\Service\Loader\YamlLoader;
use PHPUnit\Framework\TestCase;

/**
 * Description of YamlLoaderTest
 *
 * @author Wesley van den haak
 */
class YamlLoaderTest extends TestCase
{

    private YamlLoader $subject;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->subject = new YamlLoader();
    }

    /**
     * Test if the loader can load from a given file
     * @return void
     */
    public function testCanLoadFromFile(): void
    {
        $filename = dirname(dirname(__DIR__)) . '/data/files/test-configuration.yaml';
        
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

        $unknownFile = 'not_existing_file.yaml';

        $this->subject->loadFromFile($unknownFile);
    }

}
