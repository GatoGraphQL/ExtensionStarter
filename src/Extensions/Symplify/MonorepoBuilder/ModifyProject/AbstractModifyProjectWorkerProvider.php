<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\ModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\StageAwareModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\ValueObject\Stage;

abstract class AbstractModifyProjectWorkerProvider implements ModifyProjectWorkerProviderInterface
{
    /**
     * @return ModifyProjectWorkerInterface[]
     */
    public function provide(): array
    {
        return $this->getModifyProjectWorkers();
    }

    /**
     * @return ModifyProjectWorkerInterface[]
     */
    abstract protected function getModifyProjectWorkers(): array;

    /**
     * @return ModifyProjectWorkerInterface[]|StageAwareModifyProjectWorkerInterface[]
     */
    public function provideByStage(string $stage): array
    {
        if ($stage === Stage::MAIN) {
            return $this->getModifyProjectWorkers();
        }

        $activeModifyProjectWorkers = [];
        foreach ($this->getModifyProjectWorkers() as $modifyProjectWorker) {
            if (! $modifyProjectWorker instanceof StageAwareModifyProjectWorkerInterface) {
                continue;
            }

            if ($stage !== $modifyProjectWorker->getStage()) {
                continue;
            }

            $activeModifyProjectWorkers[] = $modifyProjectWorker;
        }

        return $activeModifyProjectWorkers;
    }
}
