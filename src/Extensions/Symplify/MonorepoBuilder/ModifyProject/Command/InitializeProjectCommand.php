<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Command;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Configuration\InitializeProjectStageResolver;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Configuration\ModifyProjectStageResolverInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\ModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\StageAwareModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\InitializeProjectInputObject;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InitializeProjectWorkerProvider;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Output\ModifyProjectWorkerReporter;
use Symplify\MonorepoBuilder\Validator\SourcesPresenceValidator;

final class InitializeProjectCommand extends AbstractModifyProjectCommand
{
    public function __construct(
        private InitializeProjectWorkerProvider $initializeProjectWorkerProvider,
        private InitializeProjectStageResolver $initializeProjectStageResolver,
        SourcesPresenceValidator $sourcesPresenceValidator,
        // VersionResolver $versionResolver,
        ModifyProjectWorkerReporter $modifyProjectWorkerReporter
    ) {
        parent::__construct(
            $sourcesPresenceValidator,
            // $versionResolver,
            $modifyProjectWorkerReporter,
        );
    }

    protected function configure(): void
    {
        parent::configure();
        // $this->addOption(Option::STAGE, null, InputOption::VALUE_REQUIRED, 'Name of stage to perform', Stage::MAIN);
    }

    /**
     * @return ModifyProjectWorkerInterface[]|StageAwareModifyProjectWorkerInterface[]
     */
    protected function getModifyProjectWorkers(string $stage): array
    {
        return $this->initializeProjectWorkerProvider->provideByStage($stage);
    }

    protected function getModifyProjectInputObject(string $stage): ModifyProjectInputObjectInterface
    {
        return new InitializeProjectInputObject();
    }

    protected function getModifyProjectStageResolver(): ModifyProjectStageResolverInterface
    {
        return $this->initializeProjectStageResolver;
    }

    protected function getSuccessMessage(): string
    {
        return 'The project has been successfully initialized';
    }
}
