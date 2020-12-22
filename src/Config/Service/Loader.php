<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Config\Service;

use IceCake\AppConfigurator\Common\Contract\DataSourceInterface;

/**
 * Description of Loader
 *
 * @author Wesley van den haak
 */
class Loader
{

    /**
     * @param DataSourceInterface $dataSource
     * @return array
     */
    public function load(DataSourceInterface $dataSource): array
    {
        
        $dataSource->validate();

        // @todo convert values so we avoid returning arrays
        return $dataSource->load();
    }

}
