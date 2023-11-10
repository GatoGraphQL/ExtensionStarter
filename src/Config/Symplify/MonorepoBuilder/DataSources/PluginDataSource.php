<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\PluginDataSource as UpstreamPluginDataSource;
use PoP\ExtensionStarter\Monorepo\MonorepoMetadata;

class PluginDataSource extends UpstreamPluginDataSource
{
    /**
     * @return array<array<string,mixed>>
     */
    public function getPluginConfigEntries(): array
    {
        // Plugins
        // ------------------------------------------------------------
        $pluginConfigEntries = [
            /**
             * Do not remove this comment! It is used to automatically
             * append new extension plugins when executing the
             * `create-extension` command.
             *
             * @see src/OnDemand/Symplify/MonorepoBuilder/ModifyProject/CreateExtensionWorker/UpdateMonorepoExtensionPluginConfigCreateExtensionWorker.php
             * @see UpdateMonorepoExtensionPluginConfigCreateExtensionWorker::COMMAND_PLACEHOLDER
             *
             * @gatographql-readonly-code
             */
            // { Command Placeholder: Integration plugin Composer package }

            // Gato GraphQL - Hello Dolly
            [
                'path' => 'layers/GatoGraphQLForWP/plugins/hello-dolly',
                'plugin_slug' => 'gatographql-hello-dolly',
                'main_file' => 'gatographql-hello-dolly.php',
                'rector_downgrade_config' => $this->rootDir . '/config/rector/downgrade/hello-dolly/rector.php',

                /**
                 * @gatographql-extension-info
                 *
                 * The files matching the patterns will be excluded from the
                 * generated plugin.
                 *
                 * In the case of documentation images (i.e. `'docs/images/\*'`),
                 * these are excluded, and instead they are referenced directly
                 * from the GitHub repo (pointing to raw.githubusercontent.com).
                 *
                 * @see layers/GatoGraphQLForWP/plugins/hello-dolly/src/ExtensionMetadata.php
                 *
                 * Add other entries as needed.
                 *
                 * @gatographql-example submodules/GatoGraphQL/src/Config/Symplify/MonorepoBuilder/DataSources/PluginDataSource.php
                 */
                'exclude_files' => implode(' ', [
                    'docs/images/\*',
                ]),

                /**
                 * @gatographql-extension-info
                 *
                 * Uncomment the lines below to publish the code
                 * for the generated plugin (done via the `generate_plugins`
                 * workflow in GitHub Actions) to a GitHub repo,
                 * with the repo name indicated under 'dist_repo_name'
                 * and owner under 'dist_repo_organization'
                 *
                 * (eg: https://github.com/GatoGraphQL/gatographql-hello-dolly-dist).
                 *
                 * The repository must be created if it doesn't exist.
                 *
                 * @gatographql-example submodules/GatoGraphQL/src/Config/Symplify/MonorepoBuilder/DataSources/PluginDataSource.php
                 */
                // 'dist_repo_name' => 'gatographql-hello-dolly-dist',
                // 'dist_repo_organization' => MonorepoMetadata::GITHUB_REPO_OWNER,

                /**
                 * @gatographql-extension-info
                 *
                 * If an extension makes use of 3rd-party dependencies, then these
                 * must be scoped (as to avoid potential conflicts with other plugins
                 * installed in the same WordPress site).
                 *
                 * For this, uncomment the lines below, and edit those 2 files,
                 * adding the paths to the corresponding packages that need to be scoped.
                 *
                 * @gatographql-example submodules/GatoGraphQL/src/Config/Symplify/MonorepoBuilder/DataSources/PluginDataSource.php
                 * @see https://github.com/humbug/php-scoper
                 */
                // 'scoping' => [
                //     'phpscoper_config' => $this->rootDir . '/ci/scoping/scoper-extensions.inc.php',
                //     'rector_test_config' => $this->rootDir . '/ci/scoping/rector-test-scoping-extensions.php',
                // ],
            ],
        ];

        foreach ($pluginConfigEntries as &$pluginConfigEntry) {
            $pluginConfigEntry['version'] = MonorepoMetadata::VERSION;
            $pluginConfigEntry['dist_repo_branch'] = MonorepoMetadata::GIT_BASE_BRANCH;
        }

        return $pluginConfigEntries;
    }
}
