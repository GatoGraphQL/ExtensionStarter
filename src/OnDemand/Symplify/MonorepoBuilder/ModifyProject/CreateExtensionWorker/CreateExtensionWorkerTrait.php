<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use Symplify\SmartFileSystem\SmartFileInfo;

trait CreateExtensionWorkerTrait
{
    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    protected function getIntegrationPluginWPackagistDependency(CreateExtensionInputObjectInterface $inputObject): string
    {
        return "wpackagist-plugin/{$inputObject->getIntegrationPluginSlug()}";
    }

    /**
     * @return string[]
     */
    protected function getComposerJSONPackageName(string $packageComposerJSONFile): string
    {
        $packageComposerJSONFileSmartFileInfo = new SmartFileInfo($packageComposerJSONFile);
    
        $json = $this->jsonFileManager->loadFromFileInfo($packageComposerJSONFileSmartFileInfo);
        
        return $json[ComposerJsonSection::NAME];
    }
}
