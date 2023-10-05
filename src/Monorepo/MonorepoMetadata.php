<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Monorepo;

final class MonorepoMetadata
{
    /**
     * @gatographql-extension
     * 
     * This is the version used by all packages and plugins
     * in the monorepo. During development, it has the "-dev"
     * suffix; when creating a release, this suffix is
     * automatically removed (by the "release" command).
     * This value must not be manually modified.
     *
     * ------------------------------------------------------------
     *
     * Modify this const when bumping the code to a new version.
     *
     * Important: This code is read-only! A ReleaseWorker
     * will search for this pattern using a regex, to update the
     * version when creating a new release
     * (i.e. via `composer release-major|minor|patch`).
     */
    final public const VERSION = '1.1.0-dev';

    /**
     * @gatographql-extension
     * 
     * This is needed to generate the "dev-main" alias
     * to install packages locally using Composer,
     * and the default branch to push code to when
     * doing a "monorepo split".
     */
    final public const GIT_BASE_BRANCH = 'main';

    /**
     * @gatographql-extension
     * 
     * Git user to use when doing a "monorepo split".
     */
    final public const GIT_USER_NAME = 'leoloso';

    /**
     * @gatographql-extension
     * 
     * Git email to use when doing a "monorepo split".
     */
    final public const GIT_USER_EMAIL = 'leo@getpop.org';

    /**
     * @gatographql-extension
     * 
     * GitHub organization account hosting this project,
     * as to point there to retrieve images for the plugin
     * in production (under raw.githubusercontent.com), and
     * to set as default account when doing a "monorepo split"
     */
    final public const GITHUB_REPO_OWNER = 'GatoGraphQL';

    /**
     * @gatographql-extension
     * 
     * GitHub repo name hosting this project,
     * as to point there to retrieve images for the plugin
     * in production (under raw.githubusercontent.com)
     */
    final public const GITHUB_REPO_NAME = 'ExtensionStarter';
}
