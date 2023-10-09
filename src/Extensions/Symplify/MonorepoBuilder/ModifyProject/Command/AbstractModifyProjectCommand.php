<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Command;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Configuration\ModifyProjectStageResolverInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\ModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\StageAwareModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Output\ModifyProjectWorkerReporter;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\ValueObject\Stage;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symplify\MonorepoBuilder\Validator\SourcesPresenceValidator;
use Symplify\MonorepoBuilder\ValueObject\File;
use Symplify\MonorepoBuilder\ValueObject\Option;
use Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;

abstract class AbstractModifyProjectCommand extends AbstractSymplifyCommand
{
    public function __construct(
        private SourcesPresenceValidator $sourcesPresenceValidator,
        private ModifyProjectWorkerReporter $modifyProjectWorkerReporter
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            Option::DRY_RUN,
            null,
            InputOption::VALUE_NONE,
            'Do not perform operations, just their preview'
        );

        $this->addOption(Option::STAGE, null, InputOption::VALUE_REQUIRED, 'Name of stage to perform', Stage::MAIN);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->sourcesPresenceValidator->validateRootComposerJsonName();

        // validation phase
        $stage = $this->getModifyProjectStageResolver()->resolveFromInput($input);

        $modifyProjectWorkers = $this->getModifyProjectWorkers($stage);
        if ($modifyProjectWorkers === []) {
            $errorMessage = sprintf(
                'There are no workers registered. Be sure to add them to "%s"',
                File::CONFIG
            );
            $this->symfonyStyle->error($errorMessage);

            return self::FAILURE;
        }

        // validation phase
        $inputObject = $this->getModifyProjectInputObject($input, $stage);

        $totalWorkerCount = count($modifyProjectWorkers);
        $i = 0;
        $isDryRun = (bool) $input->getOption(Option::DRY_RUN);

        foreach ($modifyProjectWorkers as $modifyProjectWorker) {
            $title = sprintf('%d/%d) ', ++$i, $totalWorkerCount) . $modifyProjectWorker->getDescription($inputObject);
            $this->symfonyStyle->title($title);
            $this->modifyProjectWorkerReporter->printMetadata($modifyProjectWorker);

            if (! $isDryRun) {
                $modifyProjectWorker->work($inputObject);
            }
        }

        if ($isDryRun) {
            $this->symfonyStyle->note('Running in dry mode, nothing is changed');
        } elseif ($stage === Stage::MAIN) {
            $message = $this->getSuccessMessage();
            $this->symfonyStyle->success($message);
        } else {
            $finishedMessage = sprintf(
                'Stage "%s" is now finished!',
                $stage
            );
            $this->symfonyStyle->success($finishedMessage);
        }

        return self::SUCCESS;
    }

    /**
     * @return ModifyProjectWorkerInterface[]|StageAwareModifyProjectWorkerInterface[]
     */
    abstract protected function getModifyProjectWorkers(string $stage): array;

    abstract protected function getModifyProjectInputObject(InputInterface $input, string $stage): ModifyProjectInputObjectInterface;

    abstract protected function getModifyProjectStageResolver(): ModifyProjectStageResolverInterface;

    protected function getSuccessMessage(): string
    {
        return 'The project has been successfully modified';
    }
}
