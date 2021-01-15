<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Config\Service;

use Wvandenhaak\Configuration\Common\Exception\ParseException;
use Wvandenhaak\Configuration\Config\Model\Config;

/**
 * Description of Parser
 *
 * @author Wesley van den haak
 */
class Parser
{
    
    /**
     * Parse an array into a config file
     * @param array $configArray
     * @return Config
     * @throws ParseException
     */
    public function parse(array $configArray): Config
    {
        if (!array_key_exists(Config::KEY, $configArray)) {
            throw new ParseException(sprintf(
                "Options are missing from the config"
            ));
        }
        
        // @todo More parsing checks
        
        // @todo Check on duplicate keys
         
        // @todo Better parsing into config        
        
        return new Config($configArray['configuration']);
    }

}
