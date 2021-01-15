<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Config\Service;

use Wvandenhaak\Configuration\Config\Model\Config;

/**
 * The merger class allows to merge multiple Configs into a single, new, Config
 *
 * @author Wesley van den haak
 */
class Merger
{

    /**
     * Merge one or more configs into a single new config.
     * The values from the base config will be overwritten if there are corresponding keys
     *
     * @param Config $base
     * @param Config ...$configs
     * @return Config
     */
    public function merge(
        Config $base,
        Config ...$configs
    ): Config
    {
        $data = $base->getAll();

        // Get arguments and remove first one (this is $base)
        $args = func_get_args();
        unset($args[0]);
        
        // Loop through all given configs and append (or overwrite) values
        foreach ($args as $appendedConfig) {
            $appendedConfigData = $appendedConfig->getAll();

            $data = array_merge($data, $appendedConfigData);
        }

        return new Config($data);
    }

}
