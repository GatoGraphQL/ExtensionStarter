<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

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
    public function getPackagePathOrganizations(): array
    {
        $packagePathOrganizations = [
            'layers/GatoGraphQLForWP/packages' => 'ExtensionVendor',
            'layers/GatoGraphQLForWP/plugins' => 'ExtensionVendor',
        ];

        if ($this->includeUpstreamPackages) {
            // From GatoGraphQL/GatoGraphQL: add '/submodules/GatoGraphQL/' to each key entry
            foreach (parent::getPackagePathOrganizations() as $upstreamPackagePath => $upstreamOrganization) {
                $packagePathOrganizations[$this->upstreamRelativeRootPath . '/' . $upstreamPackagePath] = $upstreamOrganization;
            }
        }

        return $packagePathOrganizations;
    }
}
