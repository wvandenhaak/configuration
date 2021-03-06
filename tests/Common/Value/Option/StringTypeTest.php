<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Common\Value\Option;

use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Common\Exception\InvalidArgumentException;
use Wvandenhaak\Configuration\Common\Value\Option\StringType;

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
