<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Setup;

use IceCake\AppConfigurator\Setup\Model\Option\OptionCollection;
use IceCake\AppConfigurator\Setup\Model\Setup;
use Symfony\Component\Yaml\Yaml;

/**
 * Description of Loader
 *
 * @author Wesley van den haak
 */
class Loader
{

    /**
     * @param string $file
     * @return Setup
     */
    public function load(string $file): Setup
    {
        $setupArray = Yaml::parseFile($file);

        // @todo validate array 
        
        $options = $this->parseOptions($setupArray['options']);
        
        // @todo parse grouping

        // @todo fill Setup model
        return new Setup($options, $groups);
    }

    /**
     * @return OptionCollection
     */
    private function parseOptions(array $options): OptionCollection
    {
        $collection = new OptionCollection();

        // @todo parse

        return $collection;
    }

}
