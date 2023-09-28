<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Output;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\StageAwareInterface;

final class ModifyProjectWorkerReporter
{
    public function __construct(
        private SymfonyStyle $symfonyStyle
    ) {
    }

    public function printMetadata(ReleaseWorkerInterface $releaseWorker): void
    {
        if (! $this->symfonyStyle->isVerbose()) {
            return;
        }

        // show debug data on -v/--verbose/--debug
        $this->symfonyStyle->writeln('class: ' . $releaseWorker::class);
        if ($releaseWorker instanceof StageAwareInterface) {
            $this->symfonyStyle->writeln('stage: ' . $releaseWorker->getStage());
        }

        $this->symfonyStyle->newLine();
    }
}
