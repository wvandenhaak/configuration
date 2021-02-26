<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Setup\Service;

use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Common\Exception\ParseException;
use Wvandenhaak\Configuration\Setup\Model\Group\GroupCollection;
use Wvandenhaak\Configuration\Setup\Model\Option\Option;
use Wvandenhaak\Configuration\Setup\Model\Option\OptionCollection;
use Wvandenhaak\Configuration\Setup\Service\GroupParser;
use Wvandenhaak\Configuration\Setup\Service\GroupValidator;

/**
 * Description of GroupParserTest
 */
class GroupParserTest extends TestCase
{

    private GroupParser $subject;
    private OptionCollection $optionCollectionMock;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $validator = $this->createMock(GroupValidator::class);
        $this->subject = new GroupParser($validator);

        // Mock an collection of options with 2 items
        $option1 = $this->createMock(Option::class);
        $option1->method('getKey')
            ->willReturn('key_1');

        $option2 = $this->createMock(Option::class);
        $option2->method('getKey')
            ->willReturn('key_2');

        $optionCollectionMock = $this->createMock(OptionCollection::class);
        $optionCollectionMock->method('findOption')
            ->willReturnCallback(function ($key) use ($option1, $option2) {
                switch ($key) {
                    case 'key_1':
                        $option = $option1;
                        break;
                    case 'key_2':
                        $option = $option2;
                        break;
                }

                return $option ?? null;
            });

        $this->optionCollectionMock = $optionCollectionMock;
    }

    /**
     * Test if the parser can parse an array into an collection of Groups
     * @return void
     */
    public function testCanParse(): void
    {
        $groupsArray = [
            ['name' => 'Name of Group 1', 'keys' => ['key_2']],
            ['name' => 'Group number 2', 'keys' => ['key_1']]
        ];

        // Parse into groups
        $actual = $this->subject->parse($this->optionCollectionMock, $groupsArray);

        $this->assertInstanceOf(GroupCollection::class, $actual);
        $this->assertCount(2, $actual);
    }

    /**
     * Test if the class throws ParseException(s) upon receiving invalid data
     * @return void
     */
    public function testThrowingParseExceptions(): void
    {
        $this->expectException(ParseException::class);

        // key_3 does not exist in the collection so an exception must be trhown
        $data = [
            ['name' => 'GroupName', 'keys' => ['key_3']]
        ];

        $this->subject->parse($this->optionCollectionMock, $data);
    }
}