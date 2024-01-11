<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

class TemplatePackageDataSource
{
    public function __construct(
        protected string $rootDir,
        protected string $upstreamRelativeRootPath,
    ) {
    }

    /**
     * @return array<string,string>
     */
    public function getTemplatePackagePaths(): array
    {
        return [
            'layers/GatoGraphQLForWP/plugins',
            'layers/GatoGraphQLForWP/packages',
        ];
    }

    /**
     * @return array<string>
     */
    public function getTemplatePackageDirectories(): array
    {
        return array_map(
            fn (string $packagePath) => $this->rootDir . '/templates/basic/' . $packagePath,
            $this->getTemplatePackagePaths()
        );
    }

    /**
     * @return array<string>
     */
    public function getTemplatePackageDirectoryExcludes(): array
    {
        return [];
    }
}
