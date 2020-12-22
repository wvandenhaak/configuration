<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Setup\Model\Option;

use Traversable;
use IceCake\AppConfigurator\Setup\Model\Option\Option;
use IceCake\AppConfigurator\Setup\Model\Option\OptionCollection;
use PHPUnit\Framework\TestCase;

/**
 * Description of OptionCollectionTest
 *
 * @author Wesley van den haak
 */
class OptionCollectionTest extends TestCase
{
    
    private OptionCollection $subject;
    
    /**
     * @return void
     */
    public function setUp(): void 
    {
        $this->subject = new OptionCollection();
    }
    
    /**
     * Test if Option classes are accepted by the collection and the count
     * of the set options is correct
     * @return void
     */
    public function testCanAppendElements(): void
    {
        $option = $this->createMock(Option::class);
        
        $this->subject->append($option)
                ->append($option)
                ->append($option)
                ->append($option);
        
        $this->assertCount(4, $this->subject);
    }

    /**
     * Test if the collection can (or can't) find options by a given key
     * @return void
     */
    public function testCanFindOptionBykey(): void
    {
        $exisiting_key = 'random_key';
        $non_existing_key = 'non_existing_key';

        $option = $this->createMock(Option::class);

        $option->method('getKey')
            ->willReturn($exisiting_key);

        $this->subject->append($option);

        // Expect option to be found
        $this->assertSame($option, $this->subject->findOption($exisiting_key));

        // Expect nothing found
        $this->assertNull($this->subject->findOption($non_existing_key));
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
