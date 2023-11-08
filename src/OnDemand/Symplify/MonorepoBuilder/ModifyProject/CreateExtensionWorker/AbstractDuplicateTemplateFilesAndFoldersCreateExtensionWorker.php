<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;

abstract class AbstractDuplicateTemplateFilesAndFoldersCreateExtensionWorker implements CreateExtensionWorkerInterface
{
    /**
     * @var string[]
     */
    protected array $extensionTemplateFolders;

    public function __construct()
    {
        $this->extensionTemplateFolders = $this->getExtensionTemplateFolders();
    }

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

    protected function getTemplateName(): string
    {
        return 'basic';
    }
}
