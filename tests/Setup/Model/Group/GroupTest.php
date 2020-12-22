<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Setup\Model\Group;

use IceCake\AppConfigurator\Setup\Model\Group\Group;
use IceCake\AppConfigurator\Setup\Model\Option\OptionCollection;
use PHPUnit\Framework\TestCase;

/**
 * Description of GroupTest
 *
 * @author Wesley van den haak
 */
class GroupTest extends TestCase
{
    /**
     * Test if a Group can be created and returns the same values
     * @return void
     */
    public function testCanCreate(): void
    {
        $name = 'random_group_name';
        $options = $this->createMock(OptionCollection::class);

        $subject = new Group($name, $options);

        $this->assertSame($name, $subject->getName());
        $this->assertSame($options, $subject->getOptions());
    }
}
