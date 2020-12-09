<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Test\Service\Loader;

use IceCake\AppConfigurator\Service\Loader\{
    DataSource\YamlDataSource,
    Loader
};
use PHPUnit\Framework\TestCase;

/**
 * Description of LoaderTest
 *
 * @author Wesley van den haak
 */
class LoaderTest extends TestCase
{

    private Loader $subject;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->subject = new Loader();
    }

    /**
     * Test if the loader can load from a given file
     * @return void
     */
    public function testCanLoad(): void
    {
        $dataSourceMock = $this->getMockBuilder(YamlDataSource::class)
                ->disableOriginalConstructor()
                ->getMock();
        
        $dataSourceMock->method('load')
                ->willReturn([]);

        $this->assertIsArray($this->subject->load($dataSourceMock));
    }

}
