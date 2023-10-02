<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject;

interface InitializeProjectInputObjectInterface extends ModifyProjectInputObjectInterface
{
    public function getGithubRepoOwner(): string;
    public function getGithubRepoName(): string;
    public function getDocsGitBaseBranch(): string;
    public function getDocsGithubRepoOwner(): string;
    public function getDocsGithubRepoName(): string;
}
