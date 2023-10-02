<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\InitializeProjectInputObjectInterface;

trait ReplaceMetadataInitializeProjectWorkerTrait
{
    /**
     * @param InitializeProjectInputObjectInterface $inputObject
     * @param string[] $files
     */
    public function replaceMetadataInFiles(
        InitializeProjectInputObjectInterface $inputObject,
        array $files
    ): void {
        $replacements = [
            ...$this->getRegexReplacement('GITHUB_REPO_OWNER', $inputObject->getGithubRepoOwner()),
            ...$this->getRegexReplacement('GITHUB_REPO_NAME', $inputObject->getGithubRepoName()),
        ];
        $this->fileContentReplacerSystem->replaceContentInFiles(
            $files,
            $replacements,
        );
    }

    /**
     * @return array<string,string>
     */
    protected function getRegexReplacement(string $constName, string $newValue): array
    {
        return [
            "/(\s+)const(\s+)" . $constName . "(\s+)?=(\s+)?['\"].+['\"](\s+)?;/" => " const " . $constName . " = '" . $newValue . "';",
        ];
    }
}
