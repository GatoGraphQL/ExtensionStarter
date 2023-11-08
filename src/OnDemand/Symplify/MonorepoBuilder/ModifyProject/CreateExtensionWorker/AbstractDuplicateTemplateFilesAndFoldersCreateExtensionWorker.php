<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;

abstract class AbstractDuplicateTemplateFilesAndFoldersCreateExtensionWorker implements CreateExtensionWorkerInterface
{
    /**
     * @return string[]
     */
    protected function getExtensionTemplateFolders(): array
    {
        $rootFolder = dirname(__DIR__, 6);
        $templateName = $this->getTemplateName();
        return [
            $rootFolder . '/templates/' . $templateName . '/layers/GatoGraphQLForWP/packages/extension-template-schema',
            $rootFolder . '/templates/' . $templateName . '/layers/GatoGraphQLForWP/plugins/extension-template',
        ];
    }

    /**
     * @return string[]
     */
    protected function getExtensionTemplateFiles(): array
    {
        $rootFolder = dirname(__DIR__, 6);
        return [
            $rootFolder . '/templates/shared/config/rector/downgrade/extension-template/rector.php',
            $rootFolder . '/templates/shared/src/Config/Rector/Downgrade/Configurators/ExtensionTemplateContainerConfigurationService.php',
        ];
    }

    protected function getTemplateName(): string
    {
        return 'basic';
    }
}
