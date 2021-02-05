<?php

declare(strict_types=1);

namespace Wvandenhaak\Configuration\Common\Value;

use Wvandenhaak\Configuration\Common\Exception\InvalidArgumentException;

class FilePathValue
{

    private string $filepath;

    /**
     * @param string $filepath
     */
    public function __construct(string $filepath)
    {
        $this->setFilepath($filepath);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->filepath;
    }

    /**
     * @param string $filepath
     * @throws InvalidArgumentException
     */
    private function setFilepath(string $filepath): void
    {
        // Filepath may not be an empty string
        if (empty($filepath)) {
            throw new InvalidArgumentException('Filepath is empty.');
        }

        // The filepath must be full path.
        $pathInfo = pathinfo($filepath);

        if (empty($pathInfo['filename'])) {
            throw new InvalidArgumentException('The path to the file is missing the filename.');
        }

        if (empty($pathInfo['extension'])) {
            throw new InvalidArgumentException('The path to the file is missing the file extension.');
        }

        $this->filepath = $filepath;
    }
}