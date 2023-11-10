<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Utils\ComposerUtils;
use Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use Symplify\SmartFileSystem\SmartFileInfo;

class UpdateExtensionPluginVSCodeConfigCreateExtensionWorker implements CreateExtensionWorkerInterface
{
    public function __construct(
        private JsonFileManager $jsonFileManager,
        private ComposerUtils $composerUtils,
    ) {
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        $items = [
            'Added mapping for packages'
        ];
        return sprintf(
            '%s:%s%s',
            'Update the extension plugin\'s VSCode launch.json file',
            PHP_EOL . '- ',
            implode(PHP_EOL . '- ', $items)
        );
    }

    /**
     * Check there's an integration plugin required, otherwise
     * nothing to do.
     *
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        $vscodeLaunchJSONFile = $this->getVSCodeLaunchJSONFile();
        $this->addMappingForPackagesToVSCodeLaunchJSONFile(
            $inputObject,
            $vscodeLaunchJSONFile,
        );
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    protected function addMappingForPackagesToVSCodeLaunchJSONFile(
        CreateExtensionInputObjectInterface $inputObject,
        string $vscodeLaunchJSONFile,
    ): void {
        $vscodeLaunchJSONFileSmartFileInfo = new SmartFileInfo($vscodeLaunchJSONFile);

        $json = $this->jsonFileManager->loadFromFileInfo($vscodeLaunchJSONFileSmartFileInfo);
        foreach ($json['configurations'] as &$configuration) {
            if (!str_starts_with($configuration['name'], '[Lando webserver]')) {
                continue;
            }
            $configuration['pathMappings'] = array_merge(
                $this->getVSCodeMappingEntries($inputObject),
                $configuration['pathMappings'] ?? [],
            );
        }

        $this->jsonFileManager->printJsonToFileInfo($json, $vscodeLaunchJSONFileSmartFileInfo);
    }

    protected function getVSCodeLaunchJSONFile(): string
    {
        $rootFolder = dirname(__DIR__, 6);
        return $rootFolder . '/.vscode/launch.json';
    }

    /**
     * @return string[]
     */
    protected function getVSCodeMappingEntries(CreateExtensionInputObjectInterface $inputObject): array
    {
        $extensionSlug = $inputObject->getExtensionSlug();

        $entries = [];

        /**
         * Because we don't know how "{composer-vendor}" was initialized
         * with the `initialize-project` command, retrieve the package name
         * (including the {composer-vendor} bit) from its composer.json
         */
        foreach ($this->getPackageComposerJSONFiles($inputObject) as $packageComposerJSONFile) {
            // $packageName will be "composer-vendor/{$extensionSlug}-schema"
            $packageName = $this->composerUtils->getComposerJSONPackageName($packageComposerJSONFile);
            $entries["/app/wordpress/wp-content/plugins/gatographql-{$extensionSlug}/vendor/{$packageName}"] = "layers/GatoGraphQLForWP/packages/{$extensionSlug}-schema";
        }

        // Add the entry for the plugin
        $entries["/app/wordpress/wp-content/plugins/gatographql-{$extensionSlug}"] = "layers/GatoGraphQLForWP/plugins/{$extensionSlug}";

        // Prepend the workspace folder to all entries
        return array_map(
            fn (string $entry) => '${workspaceFolder}/' . $entry,
            $entries
        );
    }

    /**
     * @return string[]
     */
    protected function getPackageComposerJSONFiles(CreateExtensionInputObjectInterface $inputObject): array
    {
        $rootFolder = dirname(__DIR__, 6);
        return [
            $rootFolder . '/layers/GatoGraphQLForWP/packages/' . $inputObject->getExtensionSlug() . '-schema/composer.json',
        ];
    }
}
