<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\SkipDowngradeTestPathsDataSource as UpstreamSkipDowngradeTestPathsDataSource;

class SkipDowngradeTestPathsDataSource extends UpstreamSkipDowngradeTestPathsDataSource
{
    public function __construct(
        string $rootDir,
        protected string $upstreamRelativeRootPath,
    ) {
        parent::__construct($rootDir);
    }

    /**
     * @return string[]
     */
    public function getSkipDowngradeTestProjectPaths(): array
    {
        return array_merge(
            array_map(
                fn (string $path) => $this->upstreamRelativeRootPath . '/' . $path,
                parent::getSkipDowngradeTestProjectPaths()
            ),
            // @todo Complete for Extension Name!
            []
        );
    }
}
