<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Setup\Model;

use IceCake\AppConfigurator\Common\Value\Option\StringType;
use IceCake\AppConfigurator\Setup\Model\Group\GroupCollection;
use IceCake\AppConfigurator\Setup\Model\Option\Option;
use IceCake\AppConfigurator\Setup\Model\Option\OptionCollection;
use IceCake\AppConfigurator\Setup\Model\Setup;
use PHPUnit\Framework\TestCase;

/**
 * Description of SetupTest
 *
 * @author Wesley van den haak
 */
class SetupTest extends TestCase
{

    /**
     * Test if a Setup object can be created and returns the same values
     * @return void
     */
    public function testCanCreate(): void
    {
        $options = $this->createMock(OptionCollection::class);
        $groups = $this->createMock(GroupCollection::class);

        $subject = new Setup($options, $groups);

        $this->assertSame($options, $subject->getOptions());
        $this->assertSame($groups, $subject->getGroups());
    }

    /**
     * Test if an value for an configuration key can be retrieved
     * @return void
     */
    public function testConfigValueRetrieval(): void
    {
        $options = $this->createMock(OptionCollection::class);

        $options->method('findOption')
            ->willReturnCallback(function($key) {
               $optionMock = null;

                if ($key == 'key_1') {
                    $optionMock = $this->getMockBuilder(Option::class)
                        ->disableOriginalConstructor()
                        ->getMock();

                    $optionMock->method('getKey')
                        ->willReturn($key);

                    $optionMock->method('getDefaultValue')
                        ->willReturn('value_1');
                }

                return $optionMock;
            });

        $groups = $this->createMock(GroupCollection::class);

        $subject = new Setup($options, $groups);

        $this->assertSame('value_1', $subject->get('key_1'));
        $this->assertSame(null, $subject->get('not_existing_key'));

    }
}
