<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\PluginDataSource;
use PoP\ExtensionStarter\Monorepo\MonorepoStaticHelpers;
use PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\ConvertVersionForProdInPluginBlockCompiledMarkdownFilesReleaseWorker as UpstreamConvertVersionForProdInPluginBlockCompiledMarkdownFilesReleaseWorker;

class ConvertVersionForProdInPluginBlockCompiledMarkdownFilesReleaseWorker extends UpstreamConvertVersionForProdInPluginBlockCompiledMarkdownFilesReleaseWorker
{
    protected function getPluginDataSource(): PluginDataSource
    {
        return new PluginDataSource(dirname(__DIR__, 6));
    }

    protected function getGitHubRepoDocsRootURL(): string
    {
        return MonorepoStaticHelpers::getGitHubRepoDocsRootURL();
    }
}
