<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Setup\Service;

use IceCake\AppConfigurator\Common\Value\Option\ArrayType;
use IceCake\AppConfigurator\Tests\data\classes\CustomOptionProvider;
use IceCake\AppConfigurator\Tests\data\classes\InvalidCustomOptionProvider;
use InvalidArgumentException;
use IceCake\AppConfigurator\Common\Value\Option\StringType;
use IceCake\AppConfigurator\Setup\Model\Option\OptionCollection;
use IceCake\AppConfigurator\Setup\Service\OptionParser;
use PHPUnit\Framework\TestCase;

/**
 * Description of OptionParserTest
 *
 * @author Wesley van den haak
 */
class OptionParserTest extends TestCase
{

    private OptionParser $subject;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->subject = new OptionParser();
    }

    /**
     * Test if the parser can parse an array into an collection of Groups
     * @return void
     */
    public function testCanParse(): void
    {
        $optionsArray = [
            ['key' => 'key_1', 'choices' => [], 'type' => StringType::class],
            ['key' => 'key_2', 'choices' => ['a', 'b', 'c'], 'type' => ArrayType::class, 'default' => ['d']],
            ['key' => 'key_3', 'provider' => CustomOptionProvider::class],
        ];

        $actual = $this->subject->parse($optionsArray);

        $this->assertInstanceOf(OptionCollection::class, $actual);
        $this->assertCount(count($optionsArray), $actual);
    }

    /**
     * Test if the class throws InvalidArgumentException(s) upon receiving invalid data
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

        // wrap data in another array because class expects array in array
        $wrappedData = [$data];
        $this->subject->parse($wrappedData);
    }

    /**
     * A dataProvider which holds different invalid values in order to test the loader if exceptions will be thrown
     * @return array
     */
    public function dataProviderInvalidSetupContents(): array
    {
        return [
            ["data" => [],                                                                           "message" => "Missing 'key' key"],
            ["data" => ['key' => 'key_1'],                                                           "message" => "Missing 'type' key"],
            ["data" => ['key' => 'key_1', 'type' => StringType::class, 'choices' => 'not_an_array'], "message" => "'choices' key must be an array"],
            ["data" => ['key' => 'key_1', 'type' => 'Not\Existing\ClassName'],                       "message" => "Given class for type does not exist"],

            ["data" => ['provider' => 'Not\Existing\ClassName'],                                     "message" => "Missing 'key' key for provider option"],
            ["data" => ['key' => 'key_2', 'provider' => ''],                                         "message" => "'provider' key may not be empty"],
            ["data" => ['key' => 'key_2', 'provider' => 'Not\Existing\ClassName'],                   "message" => "Given class for provider does not exist"],
            ["data" => ['key' => 'key_2', 'provider' => InvalidCustomOptionProvider::class],         "message" => "Provider class does not implement required interface"],
        ];
    }
}