<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorker\ReplaceMonorepoMetadataInitializeProjectWorker;

class InitializeProjectWorkersDataSource
{
    /**
     * @return string[]
     */
    public function getInitializeProjectWorkerClasses(): array
    {
        return [
            ReplaceMonorepoMetadataInitializeProjectWorker::class,
        ];
    }
}
