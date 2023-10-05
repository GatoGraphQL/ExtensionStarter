<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\PluginDataSource as UpstreamPluginDataSource;
use PoP\ExtensionStarter\Monorepo\MonorepoMetadata;

/**
 * Please notice: Presently no extension installs a 3rd party
 * package under its vendor/, hence scoping is not executed.
 *
 * If there is, add the following code to the entry:
 *
 *     ```
 *     'scoping' => [
 *         'phpscoper_config' => $this->rootDir . '/ci/scoping/scoper-extensions.inc.php',
 *         'rector_test_config' => $this->rootDir . '/ci/scoping/rector-test-scoping-extensions.php',
 *     ],
 *     ```
 *
 * ...and copy/paste/edit those 2 files, changing their paths to the extension.
 */
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
            // Gato GraphQL - Hello Dolly
            [
                'path' => 'layers/GatoGraphQLForWP/plugins/hello-dolly',
                'plugin_slug' => 'gatographql-hello-dolly',
                'main_file' => 'gatographql-hello-dolly.php',
                'exclude_files' => implode(' ', [
                    'docs/images/\*',
                ]),
                'rector_downgrade_config' => $this->rootDir . '/config/rector/downgrade/hello-dolly/rector.php',
                
                /**
                 * @gatographql-extension
                 * 
                 * Uncomment the lines below to enable publishing
                 * the generated plugin's code to a GitHub repo,
                 * with the repo name indicated under 'dist_repo_name'
                 * and owner under 'dist_repo_organization'
                 * 
                 * (eg: https://github.com/GatoGraphQL/gatographql-hello-dolly-dist).
                 * 
                 * Create the repository if it doesn't exist!
                 *
                 * @gatographql-example submodules/GatoGraphQL/src/Config/Symplify/MonorepoBuilder/DataSources/PluginDataSource.php
                 */
                // 'dist_repo_name' => 'gatographql-hello-dolly-dist',
                // 'dist_repo_organization' => MonorepoMetadata::GITHUB_REPO_OWNER,
            ],
        ];

        foreach ($pluginConfigEntries as &$pluginConfigEntry) {
            $pluginConfigEntry['version'] = MonorepoMetadata::VERSION;
            $pluginConfigEntry['dist_repo_branch'] = MonorepoMetadata::GIT_BASE_BRANCH;
        }

        return $pluginConfigEntries;
    }
}
