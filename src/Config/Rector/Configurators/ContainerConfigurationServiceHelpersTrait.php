<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Rector\Configurators;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

trait ContainerConfigurationServiceHelpersTrait
{
    /**
     * @return string[]
     */
    protected function getAllPHPFilesUnderFolder(string $dir): array
    {
        return array_values(array_filter(
            $this->getAllFilesUnderFolder($dir),
            fn(string $file) => str_ends_with($file, '.php')
        ));
    }

    /**
     * @see https://stackoverflow.com/a/24784020/14402031
     *
     * @return string[]
     */
    protected function getAllFilesUnderFolder(string $dir): array
    {
        $files = [];
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

        /** @var SplFileInfo $file */
        foreach ($rii as $file) {
            if ($file->isDir()) {
                continue;
            }

            $files[] = $file->getPathname();
        }

        return $files;
    }
}
