<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Common\Value\Option;

use Wvandenhaak\Configuration\Common\Value\Option\ArrayType;
use PHPUnit\Framework\TestCase;

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
        $value = [123, 'ABC', true];

        $stringType = new ArrayType($value);

        $this->assertSame($value, $stringType->getValue());
    }

}
