<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\ModifyProjectWorkerInterface;

final class CreateExtensionWorkerProvider extends AbstractModifyProjectWorkerProvider
{
    /**
     * @param CreateExtensionWorkerInterface[] $createExtensionWorkers
     */
    public function __construct(
        private array $createExtensionWorkers
    ) {
    }

    /**
     * @return ModifyProjectWorkerInterface[]
     */
    protected function getModifyProjectWorkers(): array
    {
        return $this->createExtensionWorkers;
    }
}
