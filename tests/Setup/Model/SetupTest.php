<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Setup\Model;

use IceCake\AppConfigurator\Setup\Model\Group\GroupCollection;
use IceCake\AppConfigurator\Setup\Model\Option\OptionCollection;
use IceCake\AppConfigurator\Setup\Model\Setup;
use PHPUnit\Framework\TestCase;

/**
 * Description of SetupTest
 *
 * @author Wesley van den haak
 */
class SetupTest extends TestCase
{

    /**
     * Test if a Setup object can be created and returns the same values
     * @return void
     */
    public function testCanCreate(): void
    {
        $options = $this->createMock(OptionCollection::class);
        $groups = $this->createMock(GroupCollection::class);

        $subject = new Setup($options, $groups);

        $this->assertSame($options, $subject->getOptions());
        $this->assertSame($groups, $subject->getGroups());
    }
}
