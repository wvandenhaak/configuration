<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Tests\Setup\Model\Group;

use Traversable;
use PHPUnit\Framework\TestCase;
use Wvandenhaak\Configuration\Setup\Model\Group\Group;
use Wvandenhaak\Configuration\Setup\Model\Group\GroupCollection;

/**
 * Description of GroupCollectionTest
 *
 * @author Wesley van den haak
 */
class GroupCollectionTest extends TestCase
{
    
    private GroupCollection $subject;
    
    /**
     * @return void
     */
    public function setUp(): void 
    {
        $this->subject = new GroupCollection();
    }
    
    /**
     * Test if Group classes are accepted by the collection and the count
     * of the set groups is correct
     * @return void
     */
    public function testCanAppendElements(): void
    {
        $group = $this->createMock(Group::class);
        
        $this->subject->append($group)
                ->append($group)
                ->append($group);
        
        $this->assertCount(3, $this->subject);
    }
    
    /**
     * Test if the class is iterable and implements the getIterator method correctly
     * @return void
     */
    public function testIterator(): void
    {
        $this->assertIsIterable($this->subject);
        $this->assertInstanceOf(Traversable::class, $this->subject->getIterator());
    }
}
