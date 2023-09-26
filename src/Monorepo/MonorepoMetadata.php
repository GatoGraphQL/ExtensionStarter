<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Monorepo;

final class MonorepoMetadata
{
    /**
     * Modify this const when bumping the code to a new version.
     *
     * Important: Do not modify the formatting of this PHP code!
     * A regex will search for this exact pattern, to update the
     * version in the ReleaseWorker when deploying for PROD.
     */
    final public const VERSION = '1.1.0-dev';

    final public const GIT_BASE_BRANCH = 'main';
    final public const GIT_USER_NAME = 'extension-git-user-name';
    final public const GIT_USER_EMAIL = 'extension-git-user@email.com';

    final public const GITHUB_REPO_OWNER = 'ExtensionRepoOwner';
    final public const GITHUB_REPO_NAME = 'ExtensionRepoName';
}
