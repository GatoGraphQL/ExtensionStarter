<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject;

interface InitializeProjectInputObjectInterface extends ModifyProjectInputObjectInterface
{
    public function getPHPNamespaceOwner(): string;
    public function getComposerVendor(): string;
    public function getInitialVersion(): string;
    public function getGitBaseBranch(): string;
    public function getGitUserName(): string;
    public function getGitUserEmail(): string;
    public function getGithubRepoOwner(): string;
    public function getGithubRepoName(): string;
    public function getDocsGitBaseBranch(): string;
    public function getDocsGithubRepoOwner(): string;
    public function getDocsGithubRepoName(): string;
    public function getMyCompanyName(): string;
    public function getMyCompanyEmail(): string;
    public function getMyCompanyWebsite(): string;
}
