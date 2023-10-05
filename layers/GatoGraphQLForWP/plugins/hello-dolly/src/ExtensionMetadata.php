<?php

declare(strict_types=1);

namespace MyCompanyForGatoGraphQL\HelloDolly;

final class ExtensionMetadata
{
    /**
     * @gatographql-extension-starter-info
     * 
     * This is the default branch to push code to when
     * doing a "monorepo split".
     */
    final public const DOCS_GIT_BASE_BRANCH = 'main';

    /**
     * @gatographql-extension-starter-info
     * 
     * GitHub organization account hosting the documentation
     * for this project (by default the project itself),
     * from which to serve images inside the plugin's documentation
     * (pointing to raw.githubusercontent.com)
     */
    final public const DOCS_GITHUB_REPO_OWNER = 'GatoGraphQL';

    /**
     * @gatographql-extension-starter-info
     * 
     * GitHub repo name hosting hosting the documentation
     * for this project (by default the project itself),
     * from which to serve images inside the plugin's documentation
     * (pointing to raw.githubusercontent.com).
     *
     * If the repo is private, the images can be copied
     * to a public repo (under the same path), as to be
     * able to access them by the generated extension.
     */
    final public const DOCS_GITHUB_REPO_NAME = 'ExtensionStarter';
}
