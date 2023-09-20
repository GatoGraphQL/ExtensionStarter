<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\PluginDataSource;
use PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\BumpVersionForDevInPluginMainFileReleaseWorker as UpstreamBumpVersionForDevInPluginMainFileReleaseWorker;

class BumpVersionForDevInPluginMainFileReleaseWorker extends UpstreamBumpVersionForDevInPluginMainFileReleaseWorker
{
    protected function getPluginDataSource(): PluginDataSource
    {
        return new PluginDataSource(dirname(__DIR__, 6));
    }
}
