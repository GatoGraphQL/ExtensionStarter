<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\ModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\StageAwareInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\ValueObject\Stage;

/**
 * @see \Symplify\MonorepoBuilder\Tests\ModifyProject\ModifyProjectWorkerProvider\ModifyProjectWorkerProviderTest
 */
final class ModifyProjectWorkerProvider
{
    /**
     * @param ModifyProjectWorkerInterface[] $modifyProjectWorkers
     */
    public function __construct(
        private array $modifyProjectWorkers
    ) {
    }

    /**
     * @return ModifyProjectWorkerInterface[]
     */
    public function provide(): array
    {
        return $this->modifyProjectWorkers;
    }

    /**
     * @return ModifyProjectWorkerInterface[]|StageAwareInterface[]
     */
    public function provideByStage(string $stage): array
    {
        if ($stage === Stage::MAIN) {
            return $this->modifyProjectWorkers;
        }

        $activeModifyProjectWorkers = [];
        foreach ($this->modifyProjectWorkers as $modifyProjectWorker) {
            if (! $modifyProjectWorker instanceof StageAwareInterface) {
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
