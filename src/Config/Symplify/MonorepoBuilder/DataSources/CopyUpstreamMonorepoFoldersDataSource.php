<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\ExtensionStarter\Monorepo\MonorepoMetadata;

class CopyUpstreamMonorepoFoldersDataSource
{
    public function __construct(
        protected string $rootDir,
        protected string $upstreamRelativeRootPath,
    ) {
    }

    /**
     * @return array<array<string,mixed>>
     */
    public function getCopyUpstreamMonorepoFoldersEntries(): array
    {
        return [
            // GitHub Workflows
            [
                'fromFolder' => $this->rootDir . '/' . $this->upstreamRelativeRootPath . '/.github/workflows',
                'toFolder' => $this->rootDir . '/.github/workflows',
                'patternReplacements' => array_merge(
                    [
                        // actions/checkout to also download git submodules
                        '#CHECKOUT_SUBMODULES:(\s+".*")?#' => 'CHECKOUT_SUBMODULES: "recursive"',
                        // Use files from upstream
                        '#ci/downgrade/before_downgrade_code\.sh#' => $this->upstreamRelativeRootPath . '/ci/downgrade/before_downgrade_code.sh',
                        '#ci/downgrade/downgrade_code\.sh#' => $this->upstreamRelativeRootPath . '/ci/downgrade/downgrade_code.sh',
                        '#ci/downgrade/after_downgrade_code\.sh#' => $this->upstreamRelativeRootPath . '/ci/downgrade/after_downgrade_code.sh',
                    ],
                    $this->runGitHubActionsOnPRs() ? [] : [
                        '/pull_request: null/' => '#pull_request: null',
                    ],
                    $this->runGitHubActionsOnPushToMaster() ? [] : [
                        '/push:(\s+)branches:(\s+)- master/' => '#push:$1#branches:$2#- master',
                    ],
                    // Replace the Git branch if needed
                    [
                        '/(#?)branches:(\s+)(#?)- master/' => '$1branches:$2$3- ' . $this->getGitMainBranch(),
                    ],
                        
                )
            ],
            // Webserver assets
            [
                'fromFolder' => $this->rootDir . '/' . $this->upstreamRelativeRootPath . '/webservers/gatographql/assets',
                'toFolder' => $this->rootDir . '/webservers/gatographql-extension-name/assets',
            ],
            [
                'fromFolder' => $this->rootDir . '/' . $this->upstreamRelativeRootPath . '/webservers/gatographql-for-prod/assets',
                'toFolder' => $this->rootDir . '/webservers/gatographql-extension-name-for-prod/assets',
            ],
            // Webserver setup
            [
                'fromFolder' => $this->rootDir . '/' . $this->upstreamRelativeRootPath . '/webservers/gatographql/setup',
                'toFolder' => $this->rootDir . '/webservers/gatographql-extension-name/setup',
                'patternReplacements' => [
                    '#gatographql.lndo.site#' => 'gatographql-extension-name.lndo.site',
                ],
            ],
            [
                'fromFolder' => $this->rootDir . '/' . $this->upstreamRelativeRootPath . '/webservers/gatographql-for-prod/setup',
                'toFolder' => $this->rootDir . '/webservers/gatographql-extension-name-for-prod/setup',
                'patternReplacements' => [
                    '#gatographql-for-prod.lndo.site#' => 'gatographql-extension-name-for-prod.lndo.site',
                ],
            ],
        ];
    }

    /**
     * Indicate if to run GitHub Actions on PRs.
     * Set to `false` to save on the 2000 minutes/month for private repos.
     *
     * After changing this value, regenerate the workflow files by running:
     *
     *   composer copy-upstream-files
     */
    protected function runGitHubActionsOnPRs(): bool
    {
        return true;
    }

    /**
     * Indicate if to run GitHub Actions when pushing to master.
     * Set to `false` to save on the 2000 minutes/month for private repos.
     *
     * After changing this value, regenerate the workflow files by running:
     *
     *   composer copy-upstream-files
     */
    protected function runGitHubActionsOnPushToMaster(): bool
    {
        return true;
    }

    protected function getGitMainBranch(): string
    {
        return MonorepoMetadata::GIT_MAIN_BRANCH;
    }
}
