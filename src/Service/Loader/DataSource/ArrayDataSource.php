<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Service\Loader\DataSource;

use Exception;
use IceCake\AppConfigurator\Contract\Loader\DataSourceInterface;
use IceCake\AppConfigurator\Exception\LoadingException;

/**
 * Loads an (returned) array from a PHP file
 *
 * @author Wesley van den haak
 */
class ArrayDataSource implements DataSourceInterface
{

    /**
     * @param string $filename
     */
    public function __construct(
        private string $filename
    )
    {
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
