<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\MonorepoSplitPackageDataSource as UpstreamMonorepoSplitPackageDataSource;

class MonorepoSplitPackageDataSource extends UpstreamMonorepoSplitPackageDataSource
{
    public function __construct(
        string $rootDir,
        protected string $upstreamRelativeRootPath,
        protected bool $includeUpstreamPackages,
    ) {
        parent::__construct($rootDir);
    }

    /**
     * @return string[]
     */
    public function getSkipMonorepoSplitPackagePaths(): array
    {
        $packagePaths = [
            'layers/GatoGraphQLForWP/packages/hello-dolly-schema',
            'layers/GatoGraphQLForWP/plugins/hello-dolly',
        ];

        if ($this->includeUpstreamPackages) {
            // From GatoGraphQL/GatoGraphQL: add 'submodules/GatoGraphQL/' to each key entry
            foreach (parent::getSkipMonorepoSplitPackagePaths() as $upstreamPackagePath) {
                $packagePaths[] = $this->upstreamRelativeRootPath . '/' . $upstreamPackagePath;
            }
        }

        return $packagePaths;
    }
}
