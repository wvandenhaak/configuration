<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Test\Common\Value\Option;

use InvalidArgumentException;
use IceCake\AppConfigurator\Common\Value\Option\StringType;
use PHPUnit\Framework\TestCase;

/**
 * Description of StringTypeTest
 *
 * @author Wesley van den haak
 */
class StringTypeTest extends TestCase
{

    /**
     * Test if the class can return the correct value
     * @return void
     */
    public function testGetValue(): void
    {
        $value = 'random string value!';

        $stringType = new StringType($value);

        $this->assertSame($value, $stringType->getValue());
    }

    /**
     * Test if an exception is trhown when an empty value is given
     * @return void
     */
    public function testExceptionOnEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $stringType = new StringType('');
    }

}
