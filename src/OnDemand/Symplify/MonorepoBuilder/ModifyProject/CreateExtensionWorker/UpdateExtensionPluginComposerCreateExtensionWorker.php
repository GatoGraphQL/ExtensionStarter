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
            'Update the extension plugin\'s composer.json file',
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
        $extensionPluginComposerJSONFile = $this->getExtensionPluginComposerJSONFile($inputObject);
        $json = $this->jsonFileManager->loadFromFileInfo(new SmartFileInfo($extensionPluginComposerJSONFile));

        $json[ComposerJsonSection::REQUIRE_DEV]["wpackagist-plugin/{$integrationPluginSlug}"] = $inputObject->getIntegrationPluginVersionConstraint();
        
        $this->jsonFileManager->printJsonToFileInfo($json, $packageComposerFileInfo);
    }

    protected function getExtensionPluginComposerJSONFile(CreateExtensionInputObjectInterface $inputObject): string
    {
        $rootFolder = dirname(__DIR__, 6);
        return $rootFolder . '/layers/GatoGraphQLForWP/plugins/' . $inputObject->getExtensionSlug() . '/composer.json';
    }
}
