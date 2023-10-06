<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use PharIo\Version\Version;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\PluginDataSource;
use PoP\PoP\Monorepo\MonorepoMetadata as UpstreamMonorepoMetadata;
use PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\AbstractConvertVersionInPluginMainFileReleaseWorker;

/**
 * Update the constraint to the Gato GraphQL plugin to its
 * latest PROD version
 */
class UpdateVersionConstraintToGatoGraphQLPluginInPluginMainFileReleaseWorker extends AbstractConvertVersionInPluginMainFileReleaseWorker
{
    public function work(Version $version): void
    {
        $requiredGatoGraphQLPluginVersion = $this->versionUtils->getRequiredCurrentFormat(UpstreamMonorepoMetadata::LATEST_PROD_VERSION);

        $replacements = [
            "/" . preg_quote('$gatoGraphQLPluginVersionConstraint') . " = '.*';/" => "\$gatoGraphQLPluginVersionConstraint = '$requiredGatoGraphQLPluginVersion';",
        ];
        $this->fileContentReplacerSystem->replaceContentInFiles($this->getPluginMainFiles(), $replacements, true);
    }

    public function getDescription(Version $version): string
    {
        return 'Update the constraint to the Gato GraphQL plugin to its latest PROD version, in the plugin main file';
    }

    protected function getPluginDataSource(): PluginDataSource
    {
        return new PluginDataSource(dirname(__DIR__, 6));
    }
}
