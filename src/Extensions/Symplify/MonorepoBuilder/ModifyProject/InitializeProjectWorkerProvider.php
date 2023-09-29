<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\InitializeProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\ModifyProjectWorkerInterface;

final class InitializeProjectWorkerProvider extends AbstractModifyProjectWorkerProvider
{
    /**
     * @param InitializeProjectWorkerInterface[] $initializeProjectWorkers
     */
    public function __construct(
        private array $initializeProjectWorkers
    ) {
    }

    /**
     * @return ModifyProjectWorkerInterface[]
     */
    protected function getModifyProjectWorkers(): array
    {
        return $this->initializeProjectWorkers;
    }
}
