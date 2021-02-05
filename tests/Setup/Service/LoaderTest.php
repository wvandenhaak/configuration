<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Setup\Service;

use ArrayIterator;
use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Common\DataSource\YamlDataSource;
use Wvandenhaak\Configuration\Common\Exception\InvalidArgumentException;
use Wvandenhaak\Configuration\Setup\Model\Group\GroupCollection;
use Wvandenhaak\Configuration\Setup\Model\Option\OptionCollection;
use Wvandenhaak\Configuration\Setup\Model\Setup;
use Wvandenhaak\Configuration\Setup\Service\GroupParser;
use Wvandenhaak\Configuration\Setup\Service\Loader;
use Wvandenhaak\Configuration\Setup\Service\OptionParser;

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
            'setup' => [
                'options' => [],
                'groups' => []
            ]
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

        // Wrap data in 'setup' key
        $data = ['setup' => $data];

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