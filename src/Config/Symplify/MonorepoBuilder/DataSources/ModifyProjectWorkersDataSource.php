<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorker\GuardOnDefaultBranchReleaseWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorker\UpdateCurrentBranchAliasReleaseWorker;

class ModifyProjectWorkersDataSource
{
    /**
     * @return string[]
     */
    public function getModifyProjectWorkerClasses(): array
    {
        return [
            GuardOnDefaultBranchReleaseWorker::class,

            /**
             * When doing a major release, the current alias must also be updated,
             * or otherwise there'll be conflicts with the "conflict" entries.
             */
            UpdateCurrentBranchAliasReleaseWorker::class,
        ];
    }
}
