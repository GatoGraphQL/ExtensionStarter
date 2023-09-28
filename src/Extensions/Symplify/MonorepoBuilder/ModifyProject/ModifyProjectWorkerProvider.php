<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject;

use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\StageAwareInterface;
use Symplify\MonorepoBuilder\Release\ValueObject\Stage;

/**
 * @see \Symplify\MonorepoBuilder\Tests\Release\ReleaseWorkerProvider\ReleaseWorkerProviderTest
 */
final class ModifyProjectWorkerProvider
{
    /**
     * @param ReleaseWorkerInterface[] $releaseWorkers
     */
    public function __construct(
        private array $releaseWorkers
    ) {
    }

    /**
     * @return ReleaseWorkerInterface[]
     */
    public function provide(): array
    {
        return $this->releaseWorkers;
    }

    /**
     * @return ReleaseWorkerInterface[]|StageAwareInterface[]
     */
    public function provideByStage(string $stage): array
    {
        if ($stage === Stage::MAIN) {
            return $this->releaseWorkers;
        }

        $activeReleaseWorkers = [];
        foreach ($this->releaseWorkers as $releaseWorker) {
            if (! $releaseWorker instanceof StageAwareInterface) {
                continue;
            }

            if ($stage !== $releaseWorker->getStage()) {
                continue;
            }

            $activeReleaseWorkers[] = $releaseWorker;
        }

        return $activeReleaseWorkers;
    }
}
