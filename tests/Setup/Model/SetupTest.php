<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Setup\Model;

use IceCake\AppConfigurator\Common\Value\Option\StringType;
use IceCake\AppConfigurator\Config\Model\Config;
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

    private Config $configMock;
    private GroupCollection $groupCollectionMock;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->groupCollectionMock = $this->createMock(GroupCollection::class);

        $this->configMock = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Test if a Setup object can be created and returns the same values
     * @return void
     */
    public function testCanCreate(): void
    {
        $options = $this->createMock(OptionCollection::class);

        $subject = new Setup($options, $this->groupCollectionMock, $this->configMock);

        $this->assertSame($options, $subject->getOptions());
        $this->assertSame($this->groupCollectionMock, $subject->getGroups());
        $this->assertSame($this->configMock, $subject->getConfig());
    }

    /**
     * Test if an value for an configuration key can be retrieved
     * @return void
     */
    public function testConfigValueRetrieval(): void
    {
        $options = $this->createMock(OptionCollection::class);

        $options->method('findOption')
            ->willReturnCallback(function ($key) {
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

        $subject = new Setup($options, $this->groupCollectionMock, $this->configMock);

        $this->assertSame('value_1', $subject->get('key_1'));
        $this->assertSame(null, $subject->get('not_existing_key'));
    }
}
