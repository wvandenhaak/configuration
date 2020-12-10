<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Test\Config\Service;

use IceCake\AppConfigurator\Config\Exception\ParseException;
use IceCake\AppConfigurator\Config\Model\Config;
use IceCake\AppConfigurator\Config\Service\Parser;
use PHPUnit\Framework\TestCase;

/**
 * Description of ParserTest
 *
 * @author Wesley van den haak
 */
class ParserTest extends TestCase
{

    private Parser $subject;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->subject = new Parser();
    }

    /**
     * Test if an array can succesfully be parsed into an Config
     * @return void
     */
    public function testCanParseIntoConfig(): void
    {
        $configArray = [
            'configuration' => [
                'key1' => 'value1',
                'key2' => 'value2'
            ]
        ];

        $config = $this->subject->parse($configArray);

        $this->assertInstanceOf(Config::class, $config);
    }

    /**
     * Test if the parser throws an error when the required key is missing (or misspelled)
     * @return void
     */
    public function testThrowsExceptionOnMissingKey(): void
    {
        $this->expectException(ParseException::class);

        $invalidConfigArray = [
            // Typo in the word 'configuration'
            'confgiuration' => [
                'key1' => 'value1',
                'key2' => 'value2'
            ]
        ];

        $this->subject->parse($invalidConfigArray);
    }

}
