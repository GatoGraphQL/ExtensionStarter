<?php

declare(strict_types=1);

namespace MyCompanyForGatoGraphQL\ExtensionTemplate;

final class ExtensionMetadata
{
    /**
     * @gatographql-project-info
     *
     * This is the branch from which to serve images
     * inside the plugin's documentation (pointing to
     * raw.githubusercontent.com) for the generated
     * plugin for DEV.
     *
     * (For the generated plugin for PROD, the {tag}
     * is used instead of the {branch}.)
     */
    final public const DOCS_GIT_BASE_BRANCH = 'main';

    /**
     * @gatographql-project-info
     *
     * GitHub organization account hosting the documentation
     * for this project (by default the project itself),
     * from which to serve images inside the plugin's documentation
     * (pointing to raw.githubusercontent.com)
     */
    final public const DOCS_GITHUB_REPO_OWNER = 'GatoGraphQL';

    /**
     * @gatographql-project-info
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
