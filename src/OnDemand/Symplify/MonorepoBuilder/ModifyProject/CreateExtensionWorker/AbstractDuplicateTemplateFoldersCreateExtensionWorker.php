<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\SmartFile\FileCopierSystem;

abstract class AbstractDuplicateTemplateFoldersCreateExtensionWorker implements CreateExtensionWorkerInterface
{
    /**
     * @var string[]
     */
    protected array $extensionTemplateFolders;

    public function __construct(
        protected FileCopierSystem $fileCopierSystem,
    ) {
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
            $rootFolder . '/templates/' . $templateName . '/GatoGraphQLForWP/packages/extension-template-schema',
            $rootFolder . '/templates/' . $templateName . '/GatoGraphQLForWP/plugins/extension-template',
        ];
    }

    protected function getTemplateName(): string
    {
        return 'basic';
    }
}
