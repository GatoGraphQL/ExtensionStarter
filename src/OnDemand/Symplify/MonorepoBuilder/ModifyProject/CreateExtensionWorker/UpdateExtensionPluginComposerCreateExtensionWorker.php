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
    use CreateExtensionWorkerTrait;

    public function __construct(
        protected JsonFileManager $jsonFileManager,
    ) {
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        $items = [];
        if ($inputObject->getIntegrationPluginSlug() !== '') {
            $items[] = sprintf(
                'Add a "require-dev" entry with "%s"',
                $this->getIntegrationPluginWPackagistDependency($inputObject)
            );
        }
        $description = 'Update the extension plugin\'s composer.json files';
        if ($items !== []) {
            return sprintf(
                '%s:%s%s',
                $description,
                PHP_EOL . '- ',
                implode(PHP_EOL . '- ', $items)
            );
        }
        return $description;
    }

    /**
     * Check there's an integration plugin required, otherwise
     * nothing to do.
     *
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        if ($inputObject->getIntegrationPluginSlug() === '') {
            return;
        }

        $composerJSONFiles = $this->getExtensionPluginComposerJSONFiles($inputObject);
        foreach ($composerJSONFiles as $composerJSONFile) {
            $this->addIntegrationPluginDependencyAsRequireDevInComposerJSON(
                $inputObject,
                $composerJSONFile,
            );
        }
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    protected function addIntegrationPluginDependencyAsRequireDevInComposerJSON(
        CreateExtensionInputObjectInterface $inputObject,
        string $composerJSONFile,
    ): void {
        $composerJSONFileSmartFileInfo = new SmartFileInfo($composerJSONFile);

        $json = $this->jsonFileManager->loadFromFileInfo($composerJSONFileSmartFileInfo);
        $json[ComposerJsonSection::REQUIRE_DEV][$this->getIntegrationPluginWPackagistDependency($inputObject)] = $inputObject->getIntegrationPluginVersionConstraint();

        $this->jsonFileManager->printJsonToFileInfo($json, $composerJSONFileSmartFileInfo);
    }

    /**
     * @return string[]
     */
    protected function getExtensionPluginComposerJSONFiles(CreateExtensionInputObjectInterface $inputObject): array
    {
        $rootFolder = dirname(__DIR__, 6);
        return [
            $rootFolder . '/layers/GatoGraphQLForWP/plugins/' . $inputObject->getExtensionSlug() . '/composer.json',
            $rootFolder . '/layers/GatoGraphQLForWP/packages/' . $inputObject->getExtensionSlug() . '-schema/composer.json',
        ];
    }
}
