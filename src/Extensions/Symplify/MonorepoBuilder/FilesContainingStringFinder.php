<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder;

use Symfony\Component\Finder\Finder;
use Symplify\SmartFileSystem\Finder\FinderSanitizer;
use Symplify\SmartFileSystem\SmartFileInfo;

final class FilesContainingStringFinder
{
    public function __construct(
        private FinderSanitizer $finderSanitizer,
    ) {
    }

    /**
     * @param string[] $folders
     * @return SmartFileInfo[] $smartFileInfos
     */
    public function findFilesContainingString(
        string $search,
        array $inFolders,
        array $excludeFolders = ['node_modules'],
        array $fileExtensions = ['*.php', '*.json'],
    ): array {
        if ($inFolders === []) {
            return [];
        }

        $finder = new Finder();
        $finder->in($inFolders)
            ->exclude($excludeFolders)
            ->files()
            ->name($fileExtensions)
            ->contains($search);

        return $this->finderSanitizer->sanitize($finder);
        // $fileSmartFileInfos = $this->finderSanitizer->sanitize($finder);
        // return array_map(
        //     fn (SmartFileInfo $smartFileInfo) => new SmartFileInfo($smartFileInfo->getRealPath() . '/package.json'),
        //     $fileSmartFileInfos
        // );
    }
}
