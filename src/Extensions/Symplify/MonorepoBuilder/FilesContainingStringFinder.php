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
     * @param string[] $searchInFolders
     * @param string[] $excludeFolders
     * @param string[] $fileExtensions
     * @return string[]
     */
    public function findFilesContainingString(
        string $search,
        array $searchInFolders,
        array $excludeFolders = [],
        array $fileExtensions = [],
        bool $ignoreDotFiles = true,
    ): array {
        if ($searchInFolders === []) {
            return [];
        }

        $finder = new Finder();
        $finder->in($searchInFolders)
            ->exclude($excludeFolders)
            ->files()
            ->ignoreDotFiles($ignoreDotFiles)
            ->name($fileExtensions)
            ->contains($search);

        $fileSmartFileInfos = $this->finderSanitizer->sanitize($finder);
        return array_map(
            fn (SmartFileInfo $smartFileInfo) => $smartFileInfo->getRealPath(),
            $fileSmartFileInfos
        );
    }
}
