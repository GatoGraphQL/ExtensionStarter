<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Command;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Configuration\InitializeProjectStageResolver;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Configuration\ModifyProjectStageResolverInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\ModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\StageAwareModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InitializeProjectWorkerProvider;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\InitializeProjectInputObject;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Output\ModifyProjectWorkerReporter;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\ValueObject\Option;
use Symfony\Component\Console\Input\InputOption;
use Symplify\MonorepoBuilder\Validator\SourcesPresenceValidator;
use Symplify\PackageBuilder\Console\Command\CommandNaming;

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

        $this->setName(CommandNaming::classToName(self::class));
        $this->setDescription('Initialize the project, replacing the extension starter data with your own data.');

        $this->addOption(
            Option::GITHUB_REPO_OWNER,
            null,
            null,
            'Owner of the GitHub repository (such as "GatoGraphQL" in "https://github.com/GatoGraphQL/ExtensionStarter"). If not provided, it retrieves this value using git',
        );
        $this->addOption(
            Option::GITHUB_REPO_NAME,
            null,
            null,
            'Name of the GitHub repository (such as "ExtensionStarter" in "https://github.com/GatoGraphQL/ExtensionStarter"). If not provided, it retrieves this value using git',
        );
        // $this->addOption(
        //     Option::GITHUB_REPO_OWNER,
        //     null,
        //     InputOption::VALUE_REQUIRED,
        //     'Name of stage to perform',
        //     Stage::MAIN
        // );
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
