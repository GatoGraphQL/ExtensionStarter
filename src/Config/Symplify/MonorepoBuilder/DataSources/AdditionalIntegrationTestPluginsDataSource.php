<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\AdditionalIntegrationTestPluginsDataSource as UpstreamAdditionalIntegrationTestPluginsDataSource;

class AdditionalIntegrationTestPluginsDataSource extends UpstreamAdditionalIntegrationTestPluginsDataSource
{
    public function __construct(
        string $rootDir,
        protected string $upstreamRelativeRootPath,
    ) {
        parent::__construct($rootDir);
    }

    /**
     * @return string[]
     */
    public function getAdditionalIntegrationTestPlugins(): array
    {
        return [];
    }
}
