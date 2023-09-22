<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

class CopyUpstreamMonorepoFilesDataSource
{
    public function __construct(
        protected string $rootDir,
        protected string $upstreamRelativeRootPath,
    ) {
    }

    /**
     * @return array<array<string,mixed>>
     */
    public function getCopyUpstreamMonorepoFilesEntries(): array
    {
        $upstreamLandoConfigFile = $this->rootDir . '/' . $this->upstreamRelativeRootPath . '/webservers/gatographql/.lando.upstream.yml';
        return [
            // Lando configs
            [
                'files' => [
                    $upstreamLandoConfigFile,
                ],
                'toFolder' => $this->rootDir . '/webservers/gatographql-extensions',
                'patternReplacements' => [
                    '#../../layers/#' => '../../' . $this->upstreamRelativeRootPath . '/layers/',
                ],
                'renameFiles' => [
                    $upstreamLandoConfigFile => '.lando.base.yml',
                ],
            ],
        ];
    }
}
