<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\SmartFile;

use PoP\PoP\Extensions\Symplify\MonorepoBuilder\SmartFile\FileContentReplacerSystem;
use Symfony\Component\Finder\Finder;
use Symplify\SmartFileSystem\FileSystemGuard;
use Symplify\SmartFileSystem\Finder\FinderSanitizer;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;

final class FileCopierSystem
{
    public function __construct(
        private SmartFileSystem $smartFileSystem,
        private FileSystemGuard $fileSystemGuard,
        private FileContentReplacerSystem $fileContentReplacerSystem,
        private FinderSanitizer $finderSanitizer,
    ) {
    }

    /**
     * @param array<string,string> $renameFiles
     * @param array<string,string> $renameFolders
     * @param array<string,string> $patternReplacements a regex pattern to search, and its replacement
     * @return string[] The copied files
     */
    public function copyFilesFromFolder(
        string $fromFolder,
        string $toFolder,
        bool $removeFilesInToFolder = false,
        array $patternReplacements = [],
        array $renameFiles = [],
        array $renameFolders = [],
    ): array {
        $this->fileSystemGuard->ensureFileExists($fromFolder, __METHOD__);

        /**
         * Remove the files in the destination folder?
         * This will guarantee that no stale images are kept.
         */
        if ($removeFilesInToFolder) {
            $this->smartFileSystem->remove($toFolder);
        }

        $finder = new Finder();
        $finder->name([
            '*', // All files
            '.*', // Including .gitignore too
        ])
            ->in($fromFolder)
            ->files()
            ->ignoreDotFiles(false);
        $smartFileInfos = $this->finderSanitizer->sanitize($finder);

        $fromFiles = array_map(
            fn (SmartFileInfo $smartFileInfo) => $smartFileInfo->getRealPath(),
            $smartFileInfos
        );

        /**
         * Group files by their folder
         *
         * @var array<string,string[]>
         */
        $dirFiles = [];
        /**
         * Calculate the $toFolder for each group of files
         *
         * @var array<string,string>
         */
        $dirToFolders = [];
        $fromFolderLength = strlen($fromFolder);
        foreach ($fromFiles as $file) {
            $dir = dirname($file);
            if (!isset($dirFiles[$dir])) {
                $subfolderPath = $renameFolders[$dir] ?? substr($dir, $fromFolderLength);
                $dirToFolders[$dir] = $toFolder . $subfolderPath;
                $dirFiles[$dir] = [];
            }
            $dirFiles[$dir][] = $file;
        }

        $copiedFiles = [];
        foreach ($dirToFolders as $dir => $dirToFolder) {
            $files = $dirFiles[$dir];
            $copiedFiles = [
                ...$copiedFiles,
                ...$this->copyFiles(
                    $files,
                    $dirToFolder,
                    $patternReplacements,
                    $renameFiles
                )
            ];
        }
        return $copiedFiles;
    }

    /**
     * @param string[] $files The file paths to copy
     * @param array<string,string> $patternReplacements a regex pattern to search, and its replacement
     * @param array<string,string> $renameFiles Key file path to copy, filename of the copied file
     * @return string[] The copied files
     */
    public function copyFiles(
        array $files,
        string $toFolder,
        array $patternReplacements = [],
        array $renameFiles = []
    ): array {
        $copiedFiles = [];
        foreach ($files as $fromFile) {
            $this->fileSystemGuard->ensureFileExists($fromFile, __METHOD__);
            $toFilename = $renameFiles[$fromFile] ?? basename($fromFile);
            $toFile = $toFolder . '/' . $toFilename;
            $this->smartFileSystem->copy($fromFile, $toFile, true);
            $copiedFiles[] = $toFile;
        }
        if ($patternReplacements !== []) {
            $this->fileContentReplacerSystem->replaceContentInFiles($copiedFiles, $patternReplacements, true);
        }
        return $copiedFiles;
    }
}
