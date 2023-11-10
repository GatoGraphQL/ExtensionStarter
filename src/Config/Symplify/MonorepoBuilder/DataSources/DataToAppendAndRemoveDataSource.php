<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\DataToAppendAndRemoveDataSource as UpstreamDataToAppendAndRemoveDataSource;

class DataToAppendAndRemoveDataSource extends UpstreamDataToAppendAndRemoveDataSource
{
    private const INTEGRATION_PLUGIN_COMPOSER_PACKAGES = [
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
        'wpackagist-plugin/hello-dolly',
    ];

    public function __construct(
        protected string $upstreamRelativeRootPath
    ) {
    }

    /**
     * @return array<string,mixed>
     */
    public function getDataToAppend(): array
    {
        $dataToAppend = parent::getDataToAppend();
        $dataToAppend['autoload']['psr-4']['PoP\\PoP\\'] = $this->upstreamRelativeRootPath . '/src';
        $dataToAppend['autoload']['psr-4']['PoP\\ExtensionStarter\\'] = 'src';
        return $dataToAppend;
    }

    /**
     * @return array<string,mixed>
     */
    public function getDataToRemove(): array
    {
        $dataToRemove = parent::getDataToRemove();
        /**
         * @gatographql-project-info
         *
         * Avoid all integration plugins from being installed
         * in the monorepo, as there's no need for them.
         *
         * (They need only be installed in the Lando sites,
         * under webservers/, for doing integration tests)
         *
         * Then run in the monorepo root folder:
         *
         * ```
         * composer merge-monorepo
         * ```
         *
         * (This will regenerate `composer.json`)
         */
        foreach (self::INTEGRATION_PLUGIN_COMPOSER_PACKAGES as $integrationPluginComposerPackage) {
            $dataToRemove['require-dev'][$integrationPluginComposerPackage] = '*';
        }
        return $dataToRemove;
    }
}
