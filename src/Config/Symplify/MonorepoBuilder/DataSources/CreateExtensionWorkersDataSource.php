<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\DuplicateTemplateFilesAndFoldersCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\UpdateMonorepoExtensionPluginConfigCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\UpdateExtensionPluginComposerCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\UpdateExtensionPluginPHPStanConfigCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\UpdateExtensionPluginVSCodeConfigCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\UpdateMonorepoLandoConfigCreateExtensionWorker;

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
            UpdateExtensionPluginVSCodeConfigCreateExtensionWorker::class,
            UpdateMonorepoExtensionPluginConfigCreateExtensionWorker::class,
            UpdateMonorepoLandoConfigCreateExtensionWorker::class,
        ];
    }
}
