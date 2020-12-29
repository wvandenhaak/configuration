<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Common\Value\Option;

use IceCake\AppConfigurator\Common\Value\Option\BooleanType;
use PHPUnit\Framework\TestCase;

/**
 * Description of BooleanTypeTest
 *
 * @author Wesley van den haak
 */
class BooleanTypeTest extends TestCase
{

    /**
     * Test if the class can return the correct value
     * @return void
     */
    public function testGetValue(): void
    {
        $value = true;

        $stringType = new BooleanType($value);

        $this->assertSame($value, $stringType->getValue());
    }

}
