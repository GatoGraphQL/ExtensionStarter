<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\ValueObject;

final class Option
{
    /**
     * @var string
     */
    public final const INITIAL_VERSION = 'initial-version';
    /**
     * @var string
     */
    public final const GIT_BASE_BRANCH = 'git-base-branch';
    /**
     * @var string
     */
    public final const GIT_USER_NAME = 'git-user-name';
    /**
     * @var string
     */
    public final const GIT_USER_EMAIL = 'git-user-email';
    /**
     * @var string
     */
    public final const GITHUB_REPO_OWNER = 'github-repo-owner';
    /**
     * @var string
     */
    public final const GITHUB_REPO_NAME = 'github-repo-name';
    /**
     * @var string
     */
    public final const DOCS_GIT_BASE_BRANCH = 'docs-git-base-branch';
    /**
     * @var string
     */
    public final const DOCS_GITHUB_REPO_OWNER = 'docs-github-repo-owner';
    /**
     * @var string
     */
    public final const DOCS_GITHUB_REPO_NAME = 'docs-github-repo-name';
}
