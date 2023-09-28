<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Configuration\StageResolver;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Output\ModifyProjectWorkerReporter;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorkerProvider;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\ValueObject\Stage;
use Symplify\MonorepoBuilder\Validator\SourcesPresenceValidator;
use Symplify\MonorepoBuilder\ValueObject\File;
use Symplify\MonorepoBuilder\ValueObject\Option;
use Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use Symplify\PackageBuilder\Console\Command\CommandNaming;

final class ModifyProjectCommand extends AbstractSymplifyCommand
{
    public function __construct(
        private ModifyProjectWorkerProvider $modifyProjectWorkerProvider,
        private SourcesPresenceValidator $sourcesPresenceValidator,
        private StageResolver $stageResolver,
        // private VersionResolver $versionResolver,
        private ModifyProjectWorkerReporter $modifyProjectWorkerReporter
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName(CommandNaming::classToName(self::class));
        $this->setDescription('Perform modifyProject process with set ModifyProject Workers.');

        // $description = sprintf(
        //     'ModifyProject version, in format "<major>.<minor>.<patch>" or "v<major>.<minor>.<patch> or one of keywords: "%s"',
        //     implode('", "', SemVersion::ALL)
        // );
        // $this->addArgument(Option::VERSION, InputArgument::REQUIRED, $description);

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
        $stage = $this->stageResolver->resolveFromInput($input);

        $modifyProjectWorkers = $this->modifyProjectWorkerProvider->provideByStage($stage);
        if ($modifyProjectWorkers === []) {
            $errorMessage = sprintf(
                'There are no modifyProject workers registered. Be sure to add them to "%s"',
                File::CONFIG
            );
            $this->symfonyStyle->error($errorMessage);

            return self::FAILURE;
        }

        $totalWorkerCount = count($modifyProjectWorkers);
        $i = 0;
        $isDryRun = (bool) $input->getOption(Option::DRY_RUN);
        // $version = $this->versionResolver->resolveVersion($input, $stage);

        foreach ($modifyProjectWorkers as $modifyProjectWorker) {
            // $title = sprintf('%d/%d) ', ++$i, $totalWorkerCount) . $modifyProjectWorker->getDescription($version);
            $title = sprintf('%d/%d) ', ++$i, $totalWorkerCount) . $modifyProjectWorker->getDescription();
            $this->symfonyStyle->title($title);
            $this->modifyProjectWorkerReporter->printMetadata($modifyProjectWorker);

            if (! $isDryRun) {
                // $modifyProjectWorker->work($version);
                $modifyProjectWorker->work();
            }
        }

        if ($isDryRun) {
            $this->symfonyStyle->note('Running in dry mode, nothing is changed');
        } elseif ($stage === Stage::MAIN) {
            // $message = sprintf('Version "%s" is now released!', $version->getVersionString());
            $message = 'The project has been successfully modified';
            $this->symfonyStyle->success($message);
        } else {
            // $finishedMessage = sprintf(
            //     'Stage "%s" for version "%s" is now finished!',
            //     $stage,
            //     $version->getVersionString()
            // );
            $finishedMessage = sprintf(
                'Stage "%s" is now finished!',
                $stage
            );
            $this->symfonyStyle->success($finishedMessage);
        }

        return self::SUCCESS;
    }
}
