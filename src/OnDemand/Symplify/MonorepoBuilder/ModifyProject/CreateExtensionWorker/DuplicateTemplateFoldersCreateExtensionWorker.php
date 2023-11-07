<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use Symplify\SmartFileSystem\SmartFileInfo;

class DuplicateTemplateFoldersCreateExtensionWorker extends AbstractDuplicateTemplateFoldersCreateExtensionWorker
{
    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        return sprintf(
            'Duplicate the extension template folders, using extension slug "%s"',
            $inputObject->getExtensionSlug()
        );
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        $folders = $this->getExtensionTemplateFolders();

        // For each entry, copy to the destination, and execute a search/replace
        $patternReplacements = $this->getPatternReplacements();
        $templateName = $this->getTemplateName();
        $extensionSlug = $inputObject->getExtensionSlug();
        foreach ($folders as $fromFolder) {
            $toFolder = str_replace(
                [
                    'templates/' . $templateName,
                    'extension-template',
                ],
                [
                    'layers',
                    $extensionSlug,
                ],
                $fromFolder
            );
            
            $renameFiles = $this->getRenameFiles(
                $fromFolder,
                $extensionSlug,
            );
            
            $this->fileCopierSystem->copyFilesFromFolder(
                $fromFolder,
                $toFolder,
                false,
                $patternReplacements,
                $renameFiles,
            );
        }
    }

    /**
     * Find files with "extension-template", and indicate how
     * to replace that name
     * 
     * @return array<string,string>
     */
    protected function getRenameFiles(
        string $fromFolder,
        string $extensionSlug,
    ): array {
        $smartFileInfos = $this->smartFinder->find([$fromFolder], '*extension-template*');
        $fromRenameFiles = array_map(
            fn (SmartFileInfo $smartFileInfo) => $smartFileInfo->getRealPath(),
            $smartFileInfos
        );
        $toRenameFiles = array_map(
            fn (string $filePath) => str_replace(
                'extension-template',
                $extensionSlug,
                basename($filePath)
            ),
            $fromRenameFiles
        );
        $renameFiles = [];
        $renameFileCount = count($fromRenameFiles);
        for ($i = 0; $i < $renameFileCount; $i++) {
            $renameFiles[$fromRenameFiles[$i]] = $toRenameFiles[$i];
        }

        return $renameFiles;
    }

    /**
     * @return string[]
     */
    protected function getPatternReplacements(): array
    {
        return [];
    }
}
