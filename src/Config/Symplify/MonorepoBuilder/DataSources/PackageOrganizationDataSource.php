<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\ExtensionStarter\Monorepo\MonorepoMetadata;
use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\PackageOrganizationDataSource as UpstreamPackageOrganizationDataSource;

class PackageOrganizationDataSource extends UpstreamPackageOrganizationDataSource
{
    public function __construct(
        string $rootDir,
        protected string $upstreamRelativeRootPath,
        protected bool $includeUpstreamPackages,
    ) {
        parent::__construct($rootDir);
    }

    /**
     * @return array<string,string>
     */
    final public function getPackagePathOrganizations(): array
    {
        $packagePathOrganizations = $this->getExtensionPackagePathOrganizations();
        if ($this->includeUpstreamPackages) {
            // From GatoGraphQL/GatoGraphQL: add 'submodules/GatoGraphQL/' to each key entry
            foreach (parent::getPackagePathOrganizations() as $upstreamPackagePath => $upstreamOrganization) {
                $packagePathOrganizations[$this->upstreamRelativeRootPath . '/' . $upstreamPackagePath] = $upstreamOrganization;
            }
        }

        return $packagePathOrganizations;
    }

    /**
     * @gatographql-project-info
     *
     * List of paths to the packages and account names in GitHub where to
     * do the "monorepo split"
     *
     * When pushing code to the repo, the "monorepo split" feature
     * copies all code for each of the modified packages into their
     * own GitHub repo, with the package name as repo name,
     * and GitHub account as defined below.
     *
     * (Eg: by setting the account name for "layers/GatoGraphQLForWP/packages"
     * to "GatoGraphQL", the package under
     * layers/GatoGraphQLForWP/packages/hello-dolly-schema will be pushed
     * to http://github.com/GatoGraphQL/hello-dolly-schema.)
     *
     * @gatographql-project-action-maybe-required
     *
     * If the "monorepo split" is enabled (i.e. if not disabled in
     * MonorepoSplitPackageDataSource.php), a GitHub repo for each
     * of the packages needs to be created.
     *
     * @see src/Config/Symplify/MonorepoBuilder/DataSources/MonorepoSplitPackageDataSource.php
     *
     * @return array<string,string>
     */
    protected function getExtensionPackagePathOrganizations(): array
    {
        return [
            'layers/GatoGraphQLForWP/packages' => MonorepoMetadata::GITHUB_REPO_OWNER,
            'layers/GatoGraphQLForWP/plugins' => MonorepoMetadata::GITHUB_REPO_OWNER,
        ];
    }
}
