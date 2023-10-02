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
use Symfony\Component\Console\Input\InputInterface;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use Symplify\MonorepoBuilder\Validator\SourcesPresenceValidator;
use Symplify\PackageBuilder\Console\Command\CommandNaming;

final class InitializeProjectCommand extends AbstractModifyProjectCommand
{
    protected ?InitializeProjectInputObject $inputObject = null;
    protected ?string $defaultGitHubRepoOwner = null;
    protected ?string $defaultGitHubRepoName = null;

    public function __construct(
        private InitializeProjectWorkerProvider $initializeProjectWorkerProvider,
        private InitializeProjectStageResolver $initializeProjectStageResolver,
        private ProcessRunner $processRunner,
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
            'Owner of the GitHub repository where this project is hosted (eg: "GatoGraphQL" in "https://github.com/GatoGraphQL/ExtensionStarter"). If not provided, this value is retrieved using `git`',
            null //$this->getDefaultGitHubRepoOwner()
        );
        $this->addOption(
            Option::GITHUB_REPO_NAME,
            null,
            null,
            'Name of the GitHub repository where this project is hosted (eg: "ExtensionStarter" in "https://github.com/GatoGraphQL/ExtensionStarter"). If not provided, this value is retrieved using `git`',
            null //$this->getDefaultGitHubRepoName()
        );

        $this->addOption(
            Option::DOCS_GITHUB_REPO_OWNER,
            null,
            null,
            sprintf(
                'Owner of the (public) GitHub repository hosting the documentation for the extension, to access the images in PROD. If not provided, the value for option `%s` is used',
                Option::GITHUB_REPO_OWNER
            ),
            null //$this->getDefaultGitHubRepoOwner()
        );
        $this->addOption(
            Option::DOCS_GITHUB_REPO_NAME,
            null,
            null,
            sprintf(
                'Name of the (public) GitHub repository hosting the documentation for the extension, to access the images in PROD. If not provided, the value for option `%s` is used',
                Option::GITHUB_REPO_NAME
            ),
            null //$this->getDefaultGitHubRepoName()
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

    protected function getModifyProjectInputObject(InputInterface $input, string $stage): ModifyProjectInputObjectInterface
    {
        if ($this->inputObject === null) {
            $githubRepoOwner = (string) $input->getOption(Option::GITHUB_REPO_OWNER);
            if ($githubRepoOwner === "") {
                $githubRepoOwner = $this->getDefaultGitHubRepoOwner();
            }
            $githubRepoName = (string) $input->getOption(Option::GITHUB_REPO_NAME);
            if ($githubRepoName === "") {
                $githubRepoName = $this->getDefaultGitHubRepoName();
            }
            $this->inputObject = new InitializeProjectInputObject(
                $githubRepoOwner,
                $githubRepoName,
            );
        }
        return $this->inputObject;
    }

    protected function getDefaultGitHubRepoOwner(): string
    {
        if ($this->defaultGitHubRepoOwner === null) {
            $this->defaultGitHubRepoOwner = trim($this->processRunner->run("basename -s .git $(dirname `git config --get remote.origin.url`)"));
        }
        return $this->defaultGitHubRepoOwner;
    }

    protected function getDefaultGitHubRepoName(): string
    {
        if ($this->defaultGitHubRepoName === null) {
            $this->defaultGitHubRepoName = trim($this->processRunner->run("basename -s .git `git config --get remote.origin.url`"));
        }
        return $this->defaultGitHubRepoName;
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
