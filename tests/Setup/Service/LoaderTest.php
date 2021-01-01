<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Setup\Service;

use ArrayIterator;
use InvalidArgumentException;
use IceCake\AppConfigurator\Common\DataSource\YamlDataSource;
use IceCake\AppConfigurator\Setup\Model\Group\GroupCollection;
use IceCake\AppConfigurator\Setup\Model\Option\OptionCollection;
use IceCake\AppConfigurator\Setup\Model\Setup;
use IceCake\AppConfigurator\Setup\Service\GroupParser;
use IceCake\AppConfigurator\Setup\Service\Loader;
use IceCake\AppConfigurator\Setup\Service\OptionParser;
use PhpParser\Node\Expr\ArrayItem;
use PHPUnit\Framework\TestCase;

/**
 * Description of GroupParser
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
        $groupCollectionMock = $this->createMock(GroupCollection::class);

        $groupParserMock = $this->createMock(GroupParser::class);
        $groupParserMock->method('parse')
            ->willReturn($groupCollectionMock);

        $optionCollectionMock = $this->createMock(OptionCollection::class);

        // Added for looping when loader creates an config object
        $optionCollectionMock->method('getIterator')
            ->willReturn(new ArrayIterator([]));

        $optionParserMock = $this->createMock(OptionParser::class);
        $optionParserMock->method('parse')
            ->willReturn($optionCollectionMock);

        $this->subject = new Loader($groupParserMock, $optionParserMock);
    }

    /**
     * Test if the loader can a DataSource into an Setup object
     * @return void
     */
    public function testCanLoad(): void
    {
        // Create correct setup array
        $setupArray = [
            'options' => [],
            'groups' => []
        ];

        $dataSouceMock = $this->createMock(YamlDataSource::class);
        $dataSouceMock->method('load')
            ->willReturn($setupArray);

        $actual = $this->subject->load($dataSouceMock);

        $this->assertInstanceOf(Setup::class, $actual);
    }

    /**
     * Test if the loader throws InvalidArgumentException(s) upon receiving invalid data
     * @dataProvider dataProviderInvalidSetupContents
     * @param array $data
     * @param string $message
     * @return void
     */
    public function testThrowingInvalidArgumentExceptions(
        array $data,
        string $message
    ): void
    {
        $this->expectException(InvalidArgumentException::class);

        // Missing 'options' key
        $dataSouceMock = $this->createMock(YamlDataSource::class);
        $dataSouceMock->method('load')
            ->willReturn($data);

        $this->subject->load($dataSouceMock);
    }

    /**
     * A dataProvider which holds different invalid values in order to test the loader if exceptions will be thrown
     * @return array
     */
    public function dataProviderInvalidSetupContents(): array
    {
        return [
            ["data" => ['options'],                                     "message" => "Missing 'groups' key"],
            ["data" => ['groups'],                                      "message" => "Missing 'options' key"],
            ["data" => ['options' => [], 'groups' => 'not_an_array'],   "message" => "Value for 'groups' not an array"],
            ["data" => ['options' => 'not_an_array', 'groups' => []],   "message" => "Value for 'options' is not an array"]
        ];
    }
}