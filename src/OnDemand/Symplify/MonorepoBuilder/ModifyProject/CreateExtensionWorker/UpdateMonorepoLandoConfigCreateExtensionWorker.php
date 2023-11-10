<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use Nette\Neon\Neon;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Utils\ComposerUtils;
use Symplify\PackageBuilder\Neon\NeonPrinter;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;

class UpdateMonorepoLandoConfigCreateExtensionWorker implements CreateExtensionWorkerInterface
{
    public function __construct(
        private NeonPrinter $neonPrinter,
        private SmartFileSystem $smartFileSystem,
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
            'Update the monorepo\'s Lando webserver config file',
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
        $landoYamlFiles = $this->getExtensionPluginLandoYamlFiles($inputObject);
        foreach ($landoYamlFiles as $landoYamlFile) {
            $this->addMappingForPackagesToLandoConfigYamlFile(
                $inputObject,
                $landoYamlFile,
            );
        }
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    protected function addMappingForPackagesToLandoConfigYamlFile(
        CreateExtensionInputObjectInterface $inputObject,
        string $landoYamlFile,
    ): void {
        $landoYamlFileSmartFileInfo = new SmartFileInfo($landoYamlFile);

        $landoYamlContent = $landoYamlFileSmartFileInfo->getContents();
        $landoYamlData = (array) Neon::decode($landoYamlContent);

        $landoYamlData['services']['appserver']['overrides']['volumes'] = array_merge(
            $this->getLandoMappingEntries($inputObject),
            $landoYamlData['services']['appserver']['overrides']['volumes'] ?? [],
        );

        $landoYamlContent = $this->neonPrinter->printNeon($landoYamlData);
        $this->smartFileSystem->dumpFile($landoYamlFile, $landoYamlContent);
    }

    /**
     * @return string[]
     */
    protected function getExtensionPluginLandoYamlFiles(CreateExtensionInputObjectInterface $inputObject): array
    {
        $rootFolder = dirname(__DIR__, 6);
        return [
            $rootFolder . '/webservers/gatographql-extensions/.lando.upstream.yml',
        ];
    }

    /**
     * @return string[]
     */
    protected function getLandoMappingEntries(CreateExtensionInputObjectInterface $inputObject): array
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
            $entries[] = sprintf(
                '%s:%s',
                "../../layers/GatoGraphQLForWP/packages/{$extensionSlug}-schema",
                "/app/wordpress/wp-content/plugins/gatographql-{$extensionSlug}/vendor/{$packageName}"
            );
        }

        // Add the entry for the plugin
        $entries[] = sprintf(
            '%s:%s',
            "../../layers/GatoGraphQLForWP/plugins/{$extensionSlug}",
            "/app/wordpress/wp-content/plugins/gatographql-{$extensionSlug}"
        );

        // Prepend the workspace folder to all entries
        return $entries;
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
