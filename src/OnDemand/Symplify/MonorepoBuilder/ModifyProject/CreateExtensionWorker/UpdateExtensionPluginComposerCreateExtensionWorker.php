<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use Symplify\SmartFileSystem\SmartFileInfo;

class UpdateExtensionPluginComposerCreateExtensionWorker implements CreateExtensionWorkerInterface
{
    public function __construct(
        protected JsonFileManager $jsonFileManager,
    ) {
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        return sprintf(
            'Add a "require-dev" entry with the integration plugin to the extension plugin\'s composer.json files',
            $inputObject->getExtensionSlug()
        );
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        $integrationPluginSlug = $inputObject->getIntegrationPluginSlug();
        if ($integrationPluginSlug === '') {
            return;
        }

        $this->addIntegrationPluginDependencyAsRequireDevInComposerJSON($inputObject);
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    protected function addIntegrationPluginDependencyAsRequireDevInComposerJSON(CreateExtensionInputObjectInterface $inputObject): void
    {
        $integrationPluginSlug = $inputObject->getIntegrationPluginSlug();

        $composerJSONFile = $this->getExtensionPluginComposerJSONFile($inputObject);
        $composerJSONFileSmartFileInfo = new SmartFileInfo($composerJSONFile);
        $json = $this->jsonFileManager->loadFromFileInfo($composerJSONFileSmartFileInfo);

        $json[ComposerJsonSection::REQUIRE_DEV]["wpackagist-plugin/{$integrationPluginSlug}"] = $inputObject->getIntegrationPluginVersionConstraint();
        
        $this->jsonFileManager->printJsonToFileInfo($json, $composerJSONFileSmartFileInfo);
    }

    protected function getExtensionPluginComposerJSONFile(CreateExtensionInputObjectInterface $inputObject): string
    {
        $rootFolder = dirname(__DIR__, 6);
        return $rootFolder . '/layers/GatoGraphQLForWP/plugins/' . $inputObject->getExtensionSlug() . '/composer.json';
    }
}
