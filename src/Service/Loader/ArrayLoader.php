<?php

declare(strict_types = 1);

namespace IceCake\AppConfigurator\Service\Loader;

use IceCake\AppConfigurator\Exception\LoadingException;
use IceCake\AppConfigurator\Service\Loader\AbstractLoader;

/**
 * Description of ArrayLoader
 *
 * @author Wesley van den haak
 */
class ArrayLoader 
{

    /**
     * @param string $filename
     * @return array
     * @throws LoadingException
     */
    public function loadFromFile(string $filename): array
    {
        if (!is_file($filename)) {
            $message = sprintf(
                'File "%s" does not exist.', 
                $filename
            );
            
            throw new LoadingException($message);
        }

        if (!is_readable($filename)) {
            $message = sprintf(
                'File "%s" is not readable.', 
                $filename
            );
            
            throw new LoadingException($message);
        }
        
        // @todo more checks before requiring?
        
        $configuration = require $filename;
        
        return $configuration;
    }

}
