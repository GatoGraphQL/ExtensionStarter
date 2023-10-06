<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Monorepo;

final class MonorepoMetadata
{
    /**
     * @gatographql-project-info
     *
     * This is the version used by all packages and plugins
     * in the monorepo. During development, it has the "-dev"
     * suffix; when creating a release, this suffix is
     * automatically removed (by the "release" command).
     * This value must not be manually modified.
     *
     * ------------------------------------------------------------
     *
     * This const will reflect the current version of the monorepo.
     *
     * Important: This code is read-only! A ReleaseWorker
     * will search for this pattern using a regex, to update the
     * version when creating a new release
     * (i.e. via `composer release-major|minor|patch`).
     *
     * @gatographql-readonly-code
     */
    final public const VERSION = '1.1.0-dev';

    /**
     * @gatographql-project-info
     *
     * This const will reflect the latest published tag in GitHub.
     *
     * Important: This code is read-only! A ReleaseWorker
     * will search for this pattern using a regex, to update the
     * version when creating a new release
     * (i.e. via `composer release-major|minor|patch`).
     *
     * @gatographql-readonly-code
     */
    final public const LATEST_PROD_VERSION = '1.0.9';

    /**
     * @gatographql-project-info
     *
     * This const is needed to generate the DEV branch alias
     * to install packages locally using Composer,
     * it is the default branch to push code to when
     * doing a "monorepo split", and the branch from which
     * to serve images inside the plugin's documentation
     * (pointing to raw.githubusercontent.com)
     */
    final public const GIT_BASE_BRANCH = 'main';

    /**
     * @gatographql-project-info
     *
     * Git user to use when doing a "monorepo split".
     */
    final public const GIT_USER_NAME = 'leoloso';

    /**
     * @gatographql-project-info
     *
     * Git email to use when doing a "monorepo split".
     */
    final public const GIT_USER_EMAIL = 'leo@getpop.org';

    /**
     * @gatographql-project-info
     *
     * GitHub organization account hosting this project,
     * from which to serve images inside the plugin's documentation
     * (pointing to raw.githubusercontent.com), and
     * to set as default account when doing a "monorepo split"
     */
    final public const GITHUB_REPO_OWNER = 'GatoGraphQL';

    /**
     * @gatographql-project-info
     *
     * GitHub repo name hosting this project, from which
     * to serve images inside the plugin's documentation
     * (pointing to raw.githubusercontent.com)
     */
    final public const GITHUB_REPO_NAME = 'ExtensionStarter';
}
