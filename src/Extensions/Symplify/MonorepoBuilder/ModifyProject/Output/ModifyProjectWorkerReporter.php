<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Output;

use Symfony\Component\Console\Style\SymfonyStyle;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\ModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\StageAwareModifyProjectWorkerInterface;

final class ModifyProjectWorkerReporter
{
    public function __construct(
        private SymfonyStyle $symfonyStyle
    ) {
    }

    public function printMetadata(ModifyProjectWorkerInterface $modifyProjectWorker): void
    {
        if (! $this->symfonyStyle->isVerbose()) {
            return;
        }

        // show debug data on -v/--verbose/--debug
        $this->symfonyStyle->writeln('class: ' . $modifyProjectWorker::class);
        if ($modifyProjectWorker instanceof StageAwareModifyProjectWorkerInterface) {
            $this->symfonyStyle->writeln('stage: ' . $modifyProjectWorker->getStage());
        }

        $this->symfonyStyle->newLine();
    }
}
