<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Rector\Configurators;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

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
     * @return string[]
     */
    protected function getAllFilesUnderFolder(string $dir): array
    {
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
        $files = []; 

        /** @var SplFileInfo $file */
        foreach ($rii as $file) {
            if ($file->isDir()){ 
                continue;
            }
                
            $files[] = $file->getPathname();        
        }

        return $files;
    }
}
