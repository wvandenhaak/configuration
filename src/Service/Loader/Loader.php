<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Service\Loader;

use IceCake\AppConfigurator\Contract\Loader\DataSourceInterface;
use IceCake\AppConfigurator\Exception\LoadingException;

/**
 * Description of YamlLoader
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
