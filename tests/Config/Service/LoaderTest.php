<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Config\Service;

use Wvandenhaak\Configuration\Common\DataSource\YamlDataSource;
use Wvandenhaak\Configuration\Config\Model\Config;
use Wvandenhaak\Configuration\Config\Service\Loader;
use Wvandenhaak\Configuration\Config\Service\Parser;
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
