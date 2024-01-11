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
     * @return array<string,string[]>
     */
    public function getTemplatePackagePaths(): array
    {
        return [
            'basic' => [
                'layers/GatoGraphQLForWP/plugins',
                'layers/GatoGraphQLForWP/packages',
            ],
        ];
    }

    /**
     * @return array<string>
     */
    public function getTemplatePackageDirectories(): array
    {
        $packageDirectories = [];
        foreach ($this->getTemplatePackagePaths() as $template => $packagePaths) {
            foreach ($packagePaths as $packagePath) {
                $packageDirectories[] = $this->rootDir . '/templates/' . $template . '/' . $packagePath;
            }
        }
        return $packageDirectories;
    }

    /**
     * @return array<string>
     */
    public function getTemplatePackageDirectoryExcludes(): array
    {
        return [];
    }
}
