<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;

class DuplicateTemplateFoldersCreateExtensionWorker extends AbstractDuplicateTemplateFoldersCreateExtensionWorker
{
    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        // $files = [
        //     $this->monorepoMetadataFile,
        // ];
        // $replacements = [];
        // foreach ($this->getReplacements($inputObject) as $constName => $newValue) {
        //     $replacements = array_merge(
        //         $replacements,
        //         $this->getRegexReplacement($constName, $newValue)
        //     );
        // }
        // $this->fileContentReplacerSystem->replaceContentInFiles(
        //     $files,
        //     $replacements,
        //     true,
        // );
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        return sprintf(
            'Duplicate the template folders, using extension slug "%s"',
            $inputObject->getExtensionSlug()
        );
    }

    // /**
    //  * @return array<string,string> Key: const name, Value: new value to set for that const
    //  */
    // protected function getReplacements(CreateExtensionInputObjectInterface $inputObject): array
    // {
    //     return [
    //         'VERSION' => $this->getInitialVersionForDev($inputObject),
    //         'LATEST_PROD_VERSION' => '',
    //         'GIT_BASE_BRANCH' => $inputObject->getGitBaseBranch(),
    //         'GIT_USER_NAME' => $inputObject->getGitUserName(),
    //         'GIT_USER_EMAIL' => $inputObject->getGitUserEmail(),
    //         'GITHUB_REPO_OWNER' => $inputObject->getGithubRepoOwner(),
    //         'GITHUB_REPO_NAME' => $inputObject->getGithubRepoName(),
    //     ];
    // }
}
