<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Setup\Model\Group;

use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Setup\Model\Group\Group;
use Wvandenhaak\Configuration\Setup\Model\Option\OptionCollection;

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
