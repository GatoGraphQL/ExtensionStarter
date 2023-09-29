<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\InitializeProjectInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;

class ReplaceMonorepoMetadataInitializeProjectWorker extends AbstractReplaceMonorepoMetadataInitializeProjectWorker
{
    /**
     * @param InitializeProjectInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        // The file has already been replaced by a previous ReleaseWorker, so the current version is that for PROD
        $replacements = [
            "/(\s+)const(\s+)GITHUB_REPO_OWNER(\s+)?=(\s+)?['\"][a-z0-9.-]+['\"](\s+)?;/" => " const GITHUB_REPO_OWNER = '" . $inputObject->getGithubRepoOwner() . "';",
            "/(\s+)const(\s+)GITHUB_REPO_NAME(\s+)?=(\s+)?['\"][a-z0-9.-]+['\"](\s+)?;/" => " const GITHUB_REPO_NAME = '" . $inputObject->getGithubRepoName() . "';",
        ];
        $this->fileContentReplacerSystem->replaceContentInFiles(
            [
                $this->monorepoMetadataFile,
            ],
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
