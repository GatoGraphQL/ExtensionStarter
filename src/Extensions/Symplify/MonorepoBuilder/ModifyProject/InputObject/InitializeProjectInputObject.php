<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject;

class InitializeProjectInputObject implements InitializeProjectInputObjectInterface
{
    public function __construct(
        private string $githubRepoOwner,
        private string $githubRepoName,
        private string $docsGitBaseBranch,
        private string $docsGithubRepoOwner,
        private string $docsGithubRepoName,
    ) {
    }

    public function getGithubRepoOwner(): string
    {
        return $this->githubRepoOwner;
    }

    public function getGithubRepoName(): string
    {
        return $this->githubRepoName;
    }

    public function getDocsGitBaseBranch(): string
    {
        return $this->docsGitBaseBranch;
    }

    public function getDocsGithubRepoOwner(): string
    {
        return $this->docsGithubRepoOwner;
    }

    public function getDocsGithubRepoName(): string
    {
        return $this->docsGithubRepoName;
    }
}
