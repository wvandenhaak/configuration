<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Test\Service;

use IceCake\AppConfigurator\Model\Config\Config;
use IceCake\AppConfigurator\Service\Merger;
use PHPUnit\Framework\TestCase;

/**
 * Description of MergerTest
 *
 * @author Wesley van den haak
 */
class MergerTest extends TestCase
{

    private Merger $subject;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->subject = new Merger();
    }

    /**
     * Test if the merge can merge multiple configs (and appends/overwrites values)
     * @return void
     */
    public function testCanMerge(): void
    {

        $base = $this->createMock(Config::class);
        $base->method('getAll')
                ->willReturn([
                    'base_key_1' => 1234,
                    'base_key_2' => true,
                    'base_key_3' => 'random_string',
                    'base_key_4' => [
                        1, 
                        2,
                        false
                    ],
                    'overwrite_all' => 1
        ]);

        $append1 = $this->createMock(Config::class);
        $append1->method('getAll')
                ->willReturn([
                    'append_1' => 'appended_string',    // Should append
                    'base_key_2' => false,              // Should overwrite
                    'overwrite_1' => 100,               // Will be overwritten
                    'overwrite_all' => 2                // Should overwrite
        ]);

        $append2 = $this->createMock(Config::class);
        $append2->method('getAll')
                ->willReturn([
                    'append_2' => ['A', 'B', 'C'],      // Should append
                    'overwrite_1' => false,             // Should overwrite
                    'overwrite_all' => '3'              // Should overwrite
        ]);

        
        // Merge all
        $mergedConfig = $this->subject->merge(
            $base,
            $append1,
            $append2
        );
        
        // Check values
        // Base
        $this->assertSame(1234, $mergedConfig->get('base_key_1'));
        $this->assertSame('random_string', $mergedConfig->get('base_key_3'));
        $this->assertSame([1, 2, false], $mergedConfig->get('base_key_4'));
        
        // Append 1 (appended and overwritten
        $this->assertSame('appended_string', $mergedConfig->get('append_1'));
        $this->assertSame(false, $mergedConfig->get('base_key_2'));
        
        // Append 2 (appended and overwritten
        $this->assertSame(['A', 'B', 'C'], $mergedConfig->get('append_2'));
        $this->assertSame(false, $mergedConfig->get('overwrite_1'));
        $this->assertSame('3', $mergedConfig->get('overwrite_all'));
    }

}
