<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Common\Value\Option;

use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Common\Exception\InvalidArgumentException;
use Wvandenhaak\Configuration\Common\Value\Option\ArrayType;

/**
 * Description of ArrayTypeTest
 *
 * @author Wesley van den haak
 */
class ArrayTypeTest extends TestCase
{

    /**
     * Test if the class can return the correct value
     * @return void
     */
    public function testGetValue(): void
    {
        $values = [123, 'ABC', true];

        $arrayType = new ArrayType($values);

        $this->assertSame($values, $arrayType->getValue());
    }

    /**
     * Test if the class trows an exception on unsupported values
     */
    public function testThrowsInvalidArgumentExceptionOnUnsupportedValues(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $values = ['key1' => [1, 2, 3]];
        new ArrayType($values);
    }

}
