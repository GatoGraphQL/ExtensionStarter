<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\SmartFile;

use PoP\PoP\Extensions\Symplify\MonorepoBuilder\SmartFile\FileContentReplacerSystem;
use Symplify\SmartFileSystem\FileSystemGuard;
use Symplify\SmartFileSystem\Finder\SmartFinder;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;

final class FileCopierSystem
{
    public function __construct(
        private SmartFileSystem $smartFileSystem,
        private FileSystemGuard $fileSystemGuard,
        private SmartFinder $smartFinder,
        private FileContentReplacerSystem $fileContentReplacerSystem,
    ) {
    }

    /**
     * @param array<string,string> $patternReplacements a regex pattern to search, and its replacement
     * @return string[] The copied files
     */
    public function copyFilesFromFolder(
        string $fromFolder,
        string $toFolder,
        bool $removeFilesInToFolder = false,
        array $patternReplacements = []
    ): array {
        $this->fileSystemGuard->ensureFileExists($fromFolder, __METHOD__);

        /**
         * Remove the files in the destination folder?
         * This will guarantee that no stale images are kept.
         */
        if ($removeFilesInToFolder) {
            $this->smartFileSystem->remove($toFolder);
        }

        $smartFileInfos = $this->smartFinder->find([$fromFolder], '*');
        $files = array_map(
            fn (SmartFileInfo $smartFileInfo) => $smartFileInfo->getRealPath(),
            $smartFileInfos
        );
        return $this->copyFiles(
            $files,
            $toFolder,
            $patternReplacements
        );
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
