<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Config\Service;

use IceCake\AppConfigurator\Common\Exception\ParseException;
use IceCake\AppConfigurator\Config\Model\Config;

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
            $message = sprintf(
                "Options are missing from the config"
            );

            throw new ParseException($message);
        }
        
        // @todo More parsing checks
        
        // @todo Check on duplicate keys
         
        // @todo Better parsing into config        
        
        return new Config($configArray['configuration']);
    }

}
