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
            $this->getExtensionSkipDowngradeTestProjectPaths()
        );
    }

    /**
     * @gatographql-project-info
     *
     * It there are packages in the monorepo that will not be
     * included in the plugin, then they need not be downgraded.
     *
     * Then list their paths here, as to avoid downgrading them.
     *
     * For instance, packages for powering PHPUnit tests,
     * under 'layers/GatoGraphQLForWP/phpunit-packages/',
     * can be skipped.
     *
     * @return string[]
     */
    protected function getExtensionSkipDowngradeTestProjectPaths(): array
    {
        return [];
    }
}
