<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Config\Service;

use Exception;
use IceCake\AppConfigurator\Common\Contract\DataStoreInterface;
use IceCake\AppConfigurator\Config\Exception\WriteException;
use IceCake\AppConfigurator\Config\Model\Config;

/**
 * Description of Writer
 *
 * @author Wesley van den haak
 */
class Writer
{

    /**
     * @param Config $config
     * @param DataStoreInterface $dataStore
     * @return void
     * @throws WriteException
     */
    public function save(
        Config $config,
        DataStoreInterface $dataStore
    ): void
    {
        try {
            $dataStore->save($config);
        } catch (Exception $ex) {
            throw new WriteException($ex->getMessage());
        }
    }

}
