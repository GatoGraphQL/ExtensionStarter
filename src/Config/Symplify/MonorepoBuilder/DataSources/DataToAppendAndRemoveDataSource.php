<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\DataToAppendAndRemoveDataSource as UpstreamDataToAppendAndRemoveDataSource;

class DataToAppendAndRemoveDataSource extends UpstreamDataToAppendAndRemoveDataSource
{
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
        $dataToRemove['require-dev']['wpackagist-plugin/hello-dolly'] = '*';
        return $dataToRemove;
    }
}
