<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\InitializeProjectWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\FilesContainingStringFinder;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\InitializeProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\InitializeProjectInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use PoP\PoP\Extensions\Symplify\MonorepoBuilder\SmartFile\FileContentReplacerSystem;

abstract class AbstractSearchAndReplaceTextInCodebaseInitializeProjectWorker implements InitializeProjectWorkerInterface
{
    public function __construct(
        private FilesContainingStringFinder $filesContainingStringFinder,
        protected FileContentReplacerSystem $fileContentReplacerSystem,
    ) {
    }

    /**
     * @param InitializeProjectInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        $searchInFolders = $this->getSearchInFolders();
        $excludeFolders = $this->getExcludeFolders();
        $fileExtensions = $this->getFileExtensions();
        foreach ($this->getReplacements($inputObject) as $search => $replace) {
            $files = $this->findFilesContainingString(
                $search,
                $searchInFolders,
                $excludeFolders,
                $fileExtensions,
                false
            );
            $this->fileContentReplacerSystem->replaceContentInFiles(
                $files,
                [
                    $search => $replace,
                ],
                false,
            );
        }
    }

    /**
     * @param string[] $searchInFolders
     * @param string[] $excludeFolders
     * @param string[] $fileExtensions
     * @return string[]
     */
    protected function findFilesContainingString(
        string $search,
        array $searchInFolders,
        array $excludeFolders,
        array $fileExtensions,
        bool $ignoreDotFiles,
    ): array {
        return $this->filesContainingStringFinder->findFilesContainingString(
            $search,
            $searchInFolders,
            $excludeFolders,
            $fileExtensions,
            $ignoreDotFiles
        );
    }

    /**
     * @return array<string,string> Key: string to search, Value: string to replace with
     */
    abstract protected function getReplacements(InitializeProjectInputObjectInterface $inputObject): array;

    /**
     * By default, directly search within the root folder
     * @return string[]
     */
    protected function getSearchInFolders(): array
    {
        return [
            $this->getRootFolder(),
        ];
    }

    protected function getRootFolder(): string
    {
        return dirname(__DIR__, 6);
    }

    /**
     * @return string[]
     */
    protected function getExcludeFolders(): array
    {
        return [
            'vendor',
        ];
    }

    /**
     * @return string[]
     */
    protected function getFileExtensions(): array
    {
        return [
            '*.php',
        ];
    }
}
