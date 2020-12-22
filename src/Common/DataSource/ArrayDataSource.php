<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\DataSource;

use Exception;
use IceCake\AppConfigurator\Common\Contract\DataSourceInterface;
use IceCake\AppConfigurator\Config\Exception\LoadingException;

/**
 * Loads an (returned) array from a PHP file
 *
 * @author Wesley van den haak
 */
class ArrayDataSource implements DataSourceInterface
{
    
    private string $filename;

    /**
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return void
     * @throws LoadingException
     */
    public function validate(): void
    {
        $message = null;
        
        if (!is_file($this->filename)) {
            $message = sprintf(
                    'File "%s" does not exist.',
                    $this->filename
            );
        }

        if (!is_readable($this->filename)) {
            $message = sprintf(
                    'File "%s" is not readable.',
                    $this->filename
            );
        }

        // @todo more checks before requiring?
        
        if ($message) {
            throw new LoadingException($message);
        }
    }

    /**
     * @return array
     * @throws LoadingException 
     */
    public function load(): array
    {
        try {
            $configuration = require $this->filename;
        } catch (Exception $ex) {
            throw new LoadingException($ex->getMessage());
        }

        return $configuration;
    }

}