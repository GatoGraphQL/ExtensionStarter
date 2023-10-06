<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use PharIo\Version\Version;
use PoP\PoP\Monorepo\MonorepoMetadata as UpstreamMonorepoMetadata;
use PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\AbstractConvertVersionInPluginMainFileReleaseWorker;

/**
 * Update the constraint to the Gato GraphQL plugin to its
 * latest PROD version
 */
class BumpVersionConstraintToGatoGraphQLPluginInPluginMainFileReleaseWorker extends AbstractConvertVersionInPluginMainFileReleaseWorker
{
    public function work(Version $version): void
    {
        $requiredGatoGraphQLPluginVersion = $this->upstreamVersionUtils->getRequiredNextFormat(UpstreamMonorepoMetadata::LATEST_PROD_VERSION);

        $replacements = [
            "/" . preg_quote('$gatoGraphQLPluginVersionConstraint') . " = '[0-9.^]+';/" => "\$gatoGraphQLPluginVersionConstraint = '$requiredGatoGraphQLPluginVersion';",
        ];
        $this->fileContentReplacerSystem->replaceContentInFiles($this->getPluginMainFiles(), $replacements, true);
    }

    public function getDescription(Version $version): string
    {
        return 'Update the constraint to the Gato GraphQL plugin to its latest PROD version, in the plugin main file';
    }
}
