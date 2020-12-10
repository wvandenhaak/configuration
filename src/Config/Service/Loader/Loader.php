<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Config\Service\Loader;

use IceCake\AppConfigurator\Config\Contract\DataSourceInterface;

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
        
        $data = $dataSource->load();

        // @todo convert values

        return $data;
    }

}
