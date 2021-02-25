<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Setup\Service;

use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Common\Value\Option\ArrayType;
use Wvandenhaak\Configuration\Common\Value\Option\StringType;
use Wvandenhaak\Configuration\Setup\Service\OptionValidator;
use Wvandenhaak\Configuration\Tests\data\classes\CustomOptionProvider;
use Wvandenhaak\Configuration\Setup\Model\Option\OptionCollection;
use Wvandenhaak\Configuration\Setup\Service\OptionParser;

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
        $validatorMock = $this->createMock(OptionValidator::class);
        $this->subject = new OptionParser($validatorMock);
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

}