<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorker\GuardOnDefaultBranchModifyProjectWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorker\ReplaceMonorepoMetadataInitializeProjectWorker;

class InitializeProjectWorkersDataSource
{
    /**
     * @return string[]
     */
    public function getInitializeProjectWorkerClasses(): array
    {
        return [
            GuardOnDefaultBranchModifyProjectWorker::class,

            /**
             * When doing a major release, the current alias must also be updated,
             * or otherwise there'll be conflicts with the "conflict" entries.
             */
            ReplaceMonorepoMetadataInitializeProjectWorker::class,
        ];
    }
}
