<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject;

class InitializeProjectInputObject implements InitializeProjectInputObjectInterface
{
    public function __construct(
        private string $initialVersion,
        private string $gitBaseBranch,
        private string $gitUserName,
        private string $gitUserEmail,
        private string $githubRepoOwner,
        private string $githubRepoName,
        private string $docsGitBaseBranch,
        private string $docsGithubRepoOwner,
        private string $docsGithubRepoName,
    ) {
    }

    public function getInitialVersion(): string
    {
        return $this->initialVersion;
    }

    public function getGitBaseBranch(): string
    {
        return $this->gitBaseBranch;
    }

    public function getGitUserName(): string
    {
        return $this->gitUserName;
    }

    public function getGitUserEmail(): string
    {
        return $this->gitUserEmail;
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
