<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\DuplicateTemplateFilesAndFoldersCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\UpdateExtensionPluginComposerCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\UpdateExtensionPluginPHPStanConfigCreateExtensionWorker;

class CreateExtensionWorkersDataSource
{
    /**
     * @return string[]
     */
    public function getCreateExtensionWorkerClasses(): array
    {
        return [
            // @todo Complete CreateExtension workers!!!
            DuplicateTemplateFilesAndFoldersCreateExtensionWorker::class,
            UpdateExtensionPluginComposerCreateExtensionWorker::class,
            UpdateExtensionPluginPHPStanConfigCreateExtensionWorker::class,
        ];
    }
}
