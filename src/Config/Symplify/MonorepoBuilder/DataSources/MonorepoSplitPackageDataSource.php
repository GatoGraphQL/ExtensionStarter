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
    final public function getSkipMonorepoSplitPackagePaths(): array
    {
        $packagePaths = $this->getExtensionSkipMonorepoSplitPackagePaths();
        if ($this->includeUpstreamPackages) {
            // From GatoGraphQL/GatoGraphQL: add 'submodules/GatoGraphQL/' to each key entry
            foreach (parent::getSkipMonorepoSplitPackagePaths() as $upstreamPackagePath) {
                $packagePaths[] = $this->upstreamRelativeRootPath . '/' . $upstreamPackagePath;
            }
        }

        return $packagePaths;
    }

    /**
     * @gatographql-project-info
     *
     * Partial paths to the packages for which to disable doing a
     * "monorepo split"
     *
     * When pushing code to the repo, the "monorepo split" feature
     * copies all code for each of the modified packages into their
     * own GitHub repo.
     *
     * (Eg: package "hello-dolly-schema" could be pushed to
     * http://github.com/GatoGraphQL/hello-dolly-schema.)
     *
     * This feature:
     *
     *   - is useful for distributing packages via Composer
     *   - allows exploring their source code outside of the monorepo
     *
     * Otherwise, it is not needed for creating a Gato GraphQL
     * extension plugin (hence all packages are disabled by default).
     *
     * @gatographql-project-action-maybe-required
     *
     * To enable doing "monorepo split", return an empty array below.
     *
     * @return string[]
     */
    protected function getExtensionSkipMonorepoSplitPackagePaths(): array
    {
        return [
            'layers/GatoGraphQLForWP/packages/',
            'layers/GatoGraphQLForWP/plugins/',
        ];
    }
}
