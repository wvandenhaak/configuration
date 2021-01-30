<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\DataSource;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use Wvandenhaak\Configuration\Common\Contract\DataSourceInterface;
use Wvandenhaak\Configuration\Common\Exception\LoadingException;
use Wvandenhaak\Configuration\Common\Value\FilePathValue;

/**
 * Loads data from a YAML file
 */
class YamlDataSource implements DataSourceInterface
{

    private FilePathValue $filePath;

    /**
     * @param FilePathValue $filePath
     */
    public function __construct(FilePathValue $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @return void
     * @throws LoadingException
     */
    public function validate(): void
    {
        $filepath = $this->filePath->getValue();

        if (!is_file($filepath)) {
            throw new LoadingException(sprintf(
                'File "%s" does not exist.',
                $filepath
            ));
        }

        if (!is_readable($filepath)) {
            throw new LoadingException(sprintf(
                'File "%s" is not readable.',
                $filepath
            ));
        }

        // @todo more checks before requiring?
    }

    /**
     * @return array
     * @throws LoadingException
     */
    public function load(): array
    {
        try {
            return Yaml::parseFile($this->filePath->getValue());
        } catch (ParseException $ex) {
            throw new LoadingException($ex->getMessage());
        }
    }

}
