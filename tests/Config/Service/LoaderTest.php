<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Config\Service;

use IceCake\AppConfigurator\Common\DataSource\YamlDataSource;
use IceCake\AppConfigurator\Config\Model\Config;
use IceCake\AppConfigurator\Config\Service\Loader;
use IceCake\AppConfigurator\Config\Service\Parser;
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
        $configMock = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();

        $parserMock = $this->createMock(Parser::class);

        $parserMock->method('parse')
            ->willReturn($configMock);

        $this->subject = new Loader($parserMock);
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

        $this->assertInstanceOf(Config::class, $this->subject->load($dataSourceMock));
    }

}
