<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Setup\Model\Option;

use IceCake\AppConfigurator\Common\Value\Option\StringType;
use IceCake\AppConfigurator\Setup\Model\Option\Option;
use PHPUnit\Framework\TestCase;

/**
 * Description of OptionTest
 *
 * @author Wesley van den haak
 */
class OptionTest extends TestCase
{
    
    /**
     * Test if an Option can be created and returns the same values
     * @return void
     */
    public function testCanCreate(): void
    {
        $key = 'random_key';
        $choices = ['random', 'value', 'to', 'choose', 'from'];
        $default = 'default_value';
        
        $defaultObject = $this->createMock(StringType::class);
        $defaultObject->method('getValue')
                ->willReturn($default);
        
        $subject = new Option($key, $defaultObject, $choices);

        $this->assertSame($key, $subject->getKey());
        $this->assertSame($choices, $subject->getChoices());
        $this->assertSame($default, $subject->getDefaultValue());
    }
}
