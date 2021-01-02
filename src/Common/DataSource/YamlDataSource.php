<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\DataSource;

use IceCake\AppConfigurator\Common\Contract\DataSourceInterface;
use IceCake\AppConfigurator\Common\Exception\LoadingException;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Loads data from a YAML file
 *
 * @author Wesley van den haak
 */
class YamlDataSource implements DataSourceInterface
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
     * @return void
     * @throws LoadingException
     */
    public function validate(): void
    {
        $message = null;

        if (!is_file($this->filename)) {
            $message = sprintf(
                'File "%s" does not exist.',
                $this->filename
            );
        }

        if (!is_readable($this->filename)) {
            $message = sprintf(
                'File "%s" is not readable.',
                $this->filename
            );
        }

        // @todo more checks before requiring?

        if ($message) {
            throw new LoadingException($message);
        }
    }

    /**
     * @return array
     * @throws LoadingException
     */
    public function load(): array
    {
        try {
            return Yaml::parseFile($this->filename);
        } catch (ParseException $ex) {
            throw new LoadingException($ex->getMessage());
        }
    }

}
