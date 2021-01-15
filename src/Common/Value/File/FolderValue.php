<?php

declare(strict_types=1);

namespace IceCake\AppConfigurator\Common\Value\File;

use InvalidArgumentException;

/**
 * Description of FolderValue
 *
 * @author Wesley van den haak
 */
class FolderValue
{

    private string $folder;

    /**
     * @param string $folder
     */
    public function __construct(string $folder)
    {
        $this->setFolder($folder);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->folder;
    }

    /**
     * @param string $folder
     * @return void
     * @trhows InvalidArgumentException
     */
    private function setFolder(string $folder): void
    {
        // Strip whitespacing
        $folder = trim($folder);

        if (empty($folder)) {
            throw new InvalidArgumentException('Folder may not be empty.');
        }

        // Strip trailing directory separator
        $folder = rtrim($folder, DIRECTORY_SEPARATOR);

        // @todo extra validation/formatting?

        $this->folder = $folder;
    }

}
