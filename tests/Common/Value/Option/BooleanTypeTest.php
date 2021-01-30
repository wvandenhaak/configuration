<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Common\Value\Option;

use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Common\Value\Option\BooleanType;

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
