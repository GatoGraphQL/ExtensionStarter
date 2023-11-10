<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\DuplicateTemplateFilesAndFoldersCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\PrintFinalInstructionsCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\RegenerateMonorepoConfigExecuteBashCommandCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\UpdateMonorepoExtensionPluginConfigCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\UpdateExtensionPluginComposerCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\UpdateExtensionPluginPHPStanConfigCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\UpdateExtensionPluginVSCodeConfigCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\UpdateMonorepoLandoBashSetupCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\UpdateMonorepoLandoComposerCreateExtensionWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\UpdateMonorepoLandoConfigCreateExtensionWorker;

class CreateExtensionWorkersDataSource
{
    /**
     * @return string[]
     */
    public function getCreateExtensionWorkerClasses(): array
    {
        return [
            DuplicateTemplateFilesAndFoldersCreateExtensionWorker::class,
            UpdateExtensionPluginComposerCreateExtensionWorker::class,
            UpdateExtensionPluginPHPStanConfigCreateExtensionWorker::class,
            UpdateExtensionPluginVSCodeConfigCreateExtensionWorker::class,
            UpdateMonorepoExtensionPluginConfigCreateExtensionWorker::class,
            UpdateMonorepoLandoConfigCreateExtensionWorker::class,
            UpdateMonorepoLandoComposerCreateExtensionWorker::class,
            UpdateMonorepoLandoBashSetupCreateExtensionWorker::class,
            RegenerateMonorepoConfigExecuteBashCommandCreateExtensionWorker::class,
            PrintFinalInstructionsCreateExtensionWorker::class,
        ];
    }
}
