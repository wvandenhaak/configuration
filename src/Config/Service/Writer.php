<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Config\Service;

use Exception;
use Wvandenhaak\Configuration\Common\Contract\DataStoreInterface;
use Wvandenhaak\Configuration\Common\Exception\WriteException;
use Wvandenhaak\Configuration\Config\Model\Config;

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
