<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\InitializeProjectInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;

class ReplaceExtensionMetadataInitializeProjectWorker extends AbstractReplaceExtensionMetadataInitializeProjectWorker
{
    use ReplaceMetadataInitializeProjectWorkerTrait;

    /**
     * @param InitializeProjectInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        $files = $this->getExtensionSrcMetadataFiles();
        $replacements = [];
        foreach ($this->getReplacements($inputObject) as $constName => $replaceWith) {
            $replacements = array_merge(
                $replacements,
                $this->getRegexReplacement($constName, $replaceWith)
            );
        }
        $this->fileContentReplacerSystem->replaceContentInFiles(
            $files,
            $replacements,
        );
    }

    /**
     * @return array<string,string>
     */
    protected function getReplacements(InitializeProjectInputObjectInterface $inputObject): array
    {
        return [
            'DOCS_GIT_BASE_BRANCH' => $inputObject->getDocsGitBaseBranch(),
            'DOCS_GITHUB_REPO_OWNER' => $inputObject->getDocsGithubRepoOwner(),
            'DOCS_GITHUB_REPO_NAME' => $inputObject->getDocsGithubRepoName(),
        ];
    }

    /**
     * @param InitializeProjectInputObjectInterface $inputObject
     */
    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        return 'Replace all properties in the ExtensionMetadata file';
    }
}
