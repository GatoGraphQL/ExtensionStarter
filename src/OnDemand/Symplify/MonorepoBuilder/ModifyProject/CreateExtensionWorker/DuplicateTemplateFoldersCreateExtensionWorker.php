<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\SmartFile\FileCopierSystem;
use Symfony\Component\Finder\Finder;
use Symplify\SmartFileSystem\Finder\FinderSanitizer;
use Symplify\SmartFileSystem\Finder\SmartFinder;
use Symplify\SmartFileSystem\SmartFileInfo;

class DuplicateTemplateFoldersCreateExtensionWorker extends AbstractDuplicateTemplateFoldersCreateExtensionWorker
{
    public function __construct(
        protected FileCopierSystem $fileCopierSystem,
        protected SmartFinder $smartFinder,
        protected FinderSanitizer $finderSanitizer,
    ) {
       parent::__construct();
    }

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
        $patternReplacements = $this->getPatternReplacements($inputObject);
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

            $renameFolders = $this->getRenameFolders(
                $fromFolder,
                $extensionSlug,
            );
            
            $this->fileCopierSystem->copyFilesFromFolder(
                $fromFolder,
                $toFolder,
                false,
                $patternReplacements,
                $renameFiles,
                $renameFolders,
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
     * Find folders with "extension-template", and indicate how
     * to replace that name
     * 
     * @return array<string,string>
     */
    protected function getRenameFolders(
        string $fromFolder,
        string $extensionSlug,
    ): array {
        $finder = new Finder();
        $finder->name('*extension-template*')
            ->in($fromFolder)
            ->directories()
            ->sortByName();
            
        $smartFileInfos = $this->finderSanitizer->sanitize($finder);
        $fromRenameFolders = array_map(
            fn (SmartFileInfo $smartFileInfo) => $smartFileInfo->getRealPath(),
            $smartFileInfos
        );
        $toRenameFolders = array_map(
            fn (string $folder) => str_replace(
                'extension-template',
                $extensionSlug,
                $folder
            ),
            $fromRenameFolders
        );
        
        $renameFolders = [];
        $renameFileCount = count($fromRenameFolders);
        for ($i = 0; $i < $renameFileCount; $i++) {
            $renameFolders[$fromRenameFolders[$i]] = $toRenameFolders[$i];
        }

        return $renameFolders;
    }

    /**
     * @return string[]
     */
    protected function getPatternReplacements(CreateExtensionInputObjectInterface $inputObject): array
    {
        return [
            "/" . preg_quote('$requiredPluginFile') . " = '.*';/" => "\$requiredPluginFile = '{$inputObject->getIntegrationPluginFile()}';",
            "/" . preg_quote('$requiredPluginVersion') . " = '.*';/" => "\$requiredPluginVersion = '{$inputObject->getIntegrationPluginVersionConstraint()}';",
            "/" . preg_quote('$requiredPluginName') . " = '.*';/" => "\$requiredPluginName = '{$inputObject->getIntegrationPluginName()}';",
            '/Extension Template/' => $inputObject->getExtensionName(),
            '/ExtensionTemplate/' => $inputObject->getExtensionClassName(),
            '/extension-template/' => $inputObject->getExtensionSlug(),
            '/EXTENSION_TEMPLATE/' => $inputObject->getExtensionModuleName(),
        ];
    }
}
