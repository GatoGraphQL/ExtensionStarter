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
        $replacements = [];
        foreach ($this->getReplacements($inputObject) as $constName => $newValue) {
            $replacements = array_merge(
                $replacements,
                $this->getRegexReplacement($constName, $newValue)
            );
        }
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

    /**
     * @return array<string,string>
     */
    protected function getReplacements(InitializeProjectInputObjectInterface $inputObject): array
    {
        return [
            'VERSION' => $this->getInitialVersionForDev($inputObject),
            'GIT_BASE_BRANCH' => $inputObject->getGitBaseBranch(),
            'GIT_USER_NAME' => $inputObject->getGitUserName(),
            'GIT_USER_EMAIL' => $inputObject->getGitUserEmail(),
            'GITHUB_REPO_OWNER' => $inputObject->getGithubRepoOwner(),
            'GITHUB_REPO_NAME' => $inputObject->getGithubRepoName(),
        ];
    }

    protected function getInitialVersionForDev(InitializeProjectInputObjectInterface $inputObject): string
    {
        return $inputObject->getInitialVersion() . '-dev';
    }
}
