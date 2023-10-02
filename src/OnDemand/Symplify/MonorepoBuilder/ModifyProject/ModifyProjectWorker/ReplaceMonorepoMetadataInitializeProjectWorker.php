<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\InitializeProjectInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;

class ReplaceMonorepoMetadataInitializeProjectWorker extends AbstractReplaceMonorepoMetadataInitializeProjectWorker
{
    use ReplaceMetadataInitializeProjectWorkerTrait;

    /**
     * @param InitializeProjectInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        $files = [
            $this->monorepoMetadataFile,
        ];
        $replacements = [
            ...$this->getRegexReplacement('VERSION', $inputObject->getInitialVersion() . '-dev'),
            ...$this->getRegexReplacement('GIT_BASE_BRANCH', $inputObject->getGitBaseBranch()),
            ...$this->getRegexReplacement('GIT_USER_NAME', $inputObject->getGitUserName()),
            ...$this->getRegexReplacement('GIT_USER_EMAIL', $inputObject->getGitUserEmail()),
            ...$this->getRegexReplacement('GITHUB_REPO_OWNER', $inputObject->getGithubRepoOwner()),
            ...$this->getRegexReplacement('GITHUB_REPO_NAME', $inputObject->getGithubRepoName()),
        ];
        $this->fileContentReplacerSystem->replaceContentInFiles(
            $files,
            $replacements,
        );
    }

    /**
     * @param InitializeProjectInputObjectInterface $inputObject
     */
    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        return 'Replace all properties in the MonorepoMetadata file';
    }
}
