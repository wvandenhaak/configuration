<?php

declare(strict_types = 1);

namespace IceCake\AppConfigurator\Service\Loader;

use IceCake\AppConfigurator\Exception\LoadingException;
use IceCake\AppConfigurator\Service\Loader\AbstractLoader;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Description of YamlLoader
 *
 * @author Wesley van den haak
 */
class YamlLoader extends AbstractLoader
{
    
    /**
     * @param string $filename
     * @return array
     * @throws LoadingException
     */
    public function loadFromFile(string $filename): array
    {
        try {
            return Yaml::parseFile($filename);
        } catch (ParseException $ex) {
            throw new LoadingException($ex->getMessage());
        }
    }

}
