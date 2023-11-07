<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\InitializeProjectWorker;

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
        foreach ($this->getReplacements($inputObject) as $constName => $newValue) {
            $replacements = array_merge(
                $replacements,
                $this->getRegexReplacement($constName, $newValue)
            );
        }
        $this->fileContentReplacerSystem->replaceContentInFiles(
            $files,
            $replacements,
            true,
        );
    }

    /**
     * @return array<string,string> Key: const name, Value: new value to set for that const
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
        return sprintf(
            'Replace properties in all Extension Metadata files: %s%s',
            PHP_EOL,
            $this->printReplacements($inputObject)
        );
    }
}
