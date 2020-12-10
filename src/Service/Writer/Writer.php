<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Service\Writer;

use Exception;
use IceCake\AppConfigurator\Contract\DataStoreInterface;
use IceCake\AppConfigurator\Exception\WriteException;

/**
 * Description of Writere
 *
 * @author Wesley van den haak
 */
class Writer
{

    private string $folderPath;

    /**
     * @param string $folderPath
     */
    public function __construct(string $folderPath)
    {
        $this->folderPath = $folderPath;
    }

    /**
     * @param DataStoreInterface $dataStore
     * @return void
     * @throws WriteException
     */
    public function save(DataStoreInterface $dataStore): void
    {
        try {
            $dataStore->save($this->folderPath);
        } catch (Exception $ex) {
            throw new WriteException($ex->getMessage());
        }
    } 

}
