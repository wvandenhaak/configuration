<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup;

use IceCake\AppConfigurator\Common\Contract\DataSourceInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Description of SetupDataSource
 *
 * @author Wesley van den haak
 */
class SetupDataSource implements DataSourceInterface
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
     * @todo: fill in validation method
     * 
     * @return void
     */
    public function validate(): void
    {
        
    }

    /**
     * @return array
     */
    public function load(): array
    {
        return Yaml::parseFile($this->filename);
    }

}
