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
        $replacements = [
            ...$this->getRegexReplacement('DOCS_GITHUB_REPO_OWNER', $inputObject->getDocsGithubRepoOwner()),
            ...$this->getRegexReplacement('DOCS_GITHUB_REPO_NAME', $inputObject->getDocsGithubRepoName()),
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
        return 'Replace all properties in the ExtensionMetadata file';
    }
}
