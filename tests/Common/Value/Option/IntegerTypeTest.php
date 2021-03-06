<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Common\Value\Option;

use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Common\Value\Option\IntegerType;

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
