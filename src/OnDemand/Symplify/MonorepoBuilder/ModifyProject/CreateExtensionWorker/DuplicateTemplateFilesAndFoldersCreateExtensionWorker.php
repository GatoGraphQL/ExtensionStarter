<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\SmartFile\FileCopierSystem;
use Symfony\Component\Finder\Finder;
use Symplify\SmartFileSystem\Finder\FinderSanitizer;
use Symplify\SmartFileSystem\Finder\SmartFinder;
use Symplify\SmartFileSystem\SmartFileInfo;

class DuplicateTemplateFilesAndFoldersCreateExtensionWorker implements CreateExtensionWorkerInterface
{
    public function __construct(
        protected FileCopierSystem $fileCopierSystem,
        protected SmartFinder $smartFinder,
        protected FinderSanitizer $finderSanitizer,
    ) {
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
        // For each entry, copy to the destination, and execute a search/replace
        $patternReplacements = $this->getPatternReplacements($inputObject);
        $template = $inputObject->getTemplate();
        $extensionSlug = $inputObject->getExtensionSlug();
     
        $templateFolders = $this->getExtensionTemplateFolders($inputObject);
        foreach ($templateFolders as $fromFolder) {
            $toFolder = str_replace(
                [
                    'templates/' . $template . '/',
                    'extension-template',
                ],
                [
                    '/',
                    $extensionSlug,
                ],
                $fromFolder
            );
            
            $renameFiles = $this->getRenameFiles(
                $inputObject,
                $fromFolder,
            );

            $renameFolders = $this->getRenameFolders(
                $inputObject,
                $fromFolder,
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

        $templateFiles = $this->getExtensionTemplateFiles($inputObject);
        foreach ($templateFiles as $templateFile) {
            $templateFileDir = dirname($templateFile);
            $toFolder = str_replace(
                [
                    'templates/shared/',
                    'extension-template',
                ],
                [
                    '/',
                    $extensionSlug,
                ],
                $templateFileDir
            );
            
            $renameFiles = $this->getRenameFiles(
                $inputObject,
                $templateFileDir,
            );
            
            $this->fileCopierSystem->copyFiles(
                [$templateFile],
                $toFolder,
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
        CreateExtensionInputObjectInterface $inputObject,
        string $fromFolder,
    ): array {
        $files = [
            ...$this->getSearchReplaceRenameFiles(
                $fromFolder,
                'extension-template',
                $inputObject->getExtensionSlug(),
            ),
            ...$this->getSearchReplaceRenameFiles(
                $fromFolder,
                'ExtensionTemplate',
                $inputObject->getExtensionClassName(),
            ),
        ];
        if ($inputObject->getIntegrationPluginSlug() !== '') {
            $files = [
                ...$files,
                ...$this->getSearchReplaceRenameFiles(
                    $fromFolder,
                    'integration-plugin-template',
                    $inputObject->getIntegrationPluginSlug(),
                ),
            ];
        }
        return $files;
    }

    /**
     * Find files with "extension-template", and indicate how
     * to replace that name
     * 
     * @return array<string,string>
     */
    protected function getSearchReplaceRenameFiles(
        string $fromFolder,
        string $search,
        string $replace
    ): array {
        $smartFileInfos = $this->smartFinder->find([$fromFolder], "*{$search}*");
        $fromRenameFiles = array_map(
            fn (SmartFileInfo $smartFileInfo) => $smartFileInfo->getRealPath(),
            $smartFileInfos
        );

        $toRenameFiles = array_map(
            fn (string $filePath) => str_replace(
                $search,
                $replace,
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
        CreateExtensionInputObjectInterface $inputObject,
        string $fromFolder,
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
        $fromFolderLength = strlen($fromFolder);
        $extensionSlug = $inputObject->getExtensionSlug();
        $toRenameFolders = array_map(
            fn (string $folder) => str_replace(
                'extension-template',
                $extensionSlug,
                substr($folder, $fromFolderLength)
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
            '/Integration Plugin Template/' => $inputObject->getIntegrationPluginName(),
            '/integration-plugin-template/' => $inputObject->getIntegrationPluginSlug(),
        ];
    }

    /**
     * @return string[]
     */
    protected function getExtensionTemplateFolders(CreateExtensionInputObjectInterface $inputObject): array
    {
        $rootFolder = dirname(__DIR__, 6);
        $template = $inputObject->getTemplate();
        return [
            $rootFolder . '/templates/' . $template . '/layers/GatoGraphQLForWP/packages/extension-template-schema',
            $rootFolder . '/templates/' . $template . '/layers/GatoGraphQLForWP/plugins/extension-template',
        ];
    }

    /**
     * @return string[]
     */
    protected function getExtensionTemplateFiles(CreateExtensionInputObjectInterface $inputObject): array
    {
        $rootFolder = dirname(__DIR__, 6);
        $files = [
            $rootFolder . '/templates/shared/config/rector/downgrade/extension-template/rector.php',
            $rootFolder . '/templates/shared/src/Config/Rector/Downgrade/Configurators/ExtensionTemplateContainerConfigurationService.php',
        ];
        if ($inputObject->getIntegrationPluginSlug() !== '') {
            $files[] = $rootFolder . '/templates/shared/stubs/wpackagist-plugin/integration-plugin-template/stubs.php';
        }
        return $files;
    }
}
