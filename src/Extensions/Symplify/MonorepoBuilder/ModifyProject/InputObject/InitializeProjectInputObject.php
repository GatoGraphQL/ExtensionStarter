<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject;

class InitializeProjectInputObject implements InitializeProjectInputObjectInterface
{
    public function __construct(
        private string $githubRepoOwner,
        private string $githubRepoName,
    ){        
    }

    public function getGithubRepoOwner(): string
    {
        return $this->githubRepoOwner;
    }

    public function getGithubRepoName(): string
    {
        return $this->githubRepoName;
    }
}
