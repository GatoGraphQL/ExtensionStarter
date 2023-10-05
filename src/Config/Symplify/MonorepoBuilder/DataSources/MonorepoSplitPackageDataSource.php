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
        /**
         * @gatographql-extension-starter When pushing code to the repo, the "monorepo split" feature
         *                                copies all code for each of the modified packages into their
         *                                own GitHub repo. (Eg: package "hello-dolly-schema" could be
         *                                pushed to http://github.com/GatoGraphQL/hello-dolly-schema)
         *                                This feature:
         *                                - is useful for distributing packages via Composer
         *                                - allows exploring their source code outside of the monorepo
         *                                Otherwise, it is not needed for creating a Gato GraphQL
         *                                extension plugin (hence it's currently disabled for all packages).
         *                                Adding the paths to the packages disables doing the "monorepo split"
         *                                on those packages.
         */
        $packagePaths = [
            'layers/GatoGraphQLForWP/packages/',
            'layers/GatoGraphQLForWP/plugins/',
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
