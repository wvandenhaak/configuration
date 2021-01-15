<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\Value\File;

use InvalidArgumentException;

/**
 * Description of FilenameValue
 *
 * @author Wesley van den haak
 */
class FileNameValue
{

    private string $fileName;
    private string $fileExtension;

    /**
     * @param string $name
     * @param string $extension
     */
    public function __construct(
        string $name,
        string $extension
    )
    {
        $this->setFileName($name);
        $this->setFileExtension($extension);
    }

    /**
     * Returns the filename
     * @return string
     */
    public function getValue(): string
    {
        return $this->fileName . '.' . $this->fileExtension;
    }

    /**
     * @param string $filename
     * @return void
     * @throws InvalidArgumentException
     */
    private function setFileName(string $filename): void
    {
        // Strip whitespacing
        $filename = trim($filename);
        
        if (empty($filename)) {
            throw new InvalidArgumentException('Filename may not be empty.');
        }
        
        // Use pathinfo() to parse the file name in case a filepath is given.
        // Filepath returns empty filename when an incomplete path is given
        // e.g. 'folder_name/.html'
        $pathInfo = pathinfo($filename);

        if (empty($pathInfo['filename'])) {
            throw new InvalidArgumentException(sprintf(
                "Failed to parse filename from value (%s).",
                $filename
            ));
        }

        $this->fileName = $pathInfo['filename'];
    }

    /**
     * @param string $name
     * @return void
     * @throws InvalidArgumentException
     */
    private function setFileExtension(string $extension): void
    {
        // Strip whitespacing
        $extension = trim($extension);
        
        if (empty($extension)) {
            throw new InvalidArgumentException('File extension may not be empty.');
        }

        // Strip leading . (dot)
        $extension = ltrim($extension, '.');

        // @todo extra validation/formatting?

        $this->fileExtension = $extension;
    }

}
