<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Common\Value\Option;

use IceCake\AppConfigurator\Common\Value\Option\IntegerType;
use PHPUnit\Framework\TestCase;

/**
 * Description of IntegerTypeTest
 *
 * @author Wesley van den haak
 */
class IntegerTypeTest extends TestCase
{

    /**
     * Test if the class can return the correct value
     * @return void
     */
    public function testGetValue(): void
    {
        $value = 12345;

        $stringType = new IntegerType($value);

        $this->assertSame($value, $stringType->getValue());
    }

}
