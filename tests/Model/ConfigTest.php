<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Tests\Model;

use IceCake\AppConfigurator\Model\Config;
use PHPUnit\Framework\TestCase;

/**
 * Description of ConfigTest
 *
 * @author Wesley van den haak
 */
class ConfigTest extends TestCase
{
    
    /**
     * Test basic functionality of the config model
     * @return void
     */
    public function testConfigValuesRetrieval(): void
    {
        $stringValue =  'This is a string';
        $arrayValue = [1, 'a', true, 29];
        $booleanValue = true;
        
        $configOptions = [
            'string_value' => $stringValue,
            'array_value' => $arrayValue,
            'boolean_value' => $booleanValue
        ];
        
        $config = new Config($configOptions);
        
        // Test if strings are supported
        $this->assertIsString($config->get('string_value'));
        $this->assertEquals($stringValue, $config->get('string_value'));
        
        // Test if arrays are supported
        $this->assertIsArray($config->get('array_value'));
        $this->assertEquals($arrayValue, $config->get('array_value'));
        
        // Test if booleans are supported
        $this->assertIsBool($config->get('boolean_value'));
        $this->assertEquals($booleanValue, $config->get('boolean_value'));
        
        // Test if null is returned on undefined keys
        $this->assertNull($config->get('random_undefined_key'));
        
        // Test if alle values can be returned at once
        $this->assertSame($configOptions, $config->getAll());
    }
}
