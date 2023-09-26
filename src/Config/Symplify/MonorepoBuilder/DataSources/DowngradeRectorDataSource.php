<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\DowngradeRectorDataSource as UpstreamDowngradeRectorDataSource;

class DowngradeRectorDataSource extends UpstreamDowngradeRectorDataSource
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
    public function getAdditionalDowngradeRectorFiles(): array
    {
        return [
            $this->rootDir . '/' . $this->upstreamRelativeRootPath . '/config/rector/downgrade/monorepo/chained-rules/rector-arrowfunction-mixedtype.php',
            $this->rootDir . '/' . $this->upstreamRelativeRootPath . '/config/rector/downgrade/monorepo/chained-rules/rector-arrowfunction-uniontype.php',
            $this->rootDir . '/config/rector/downgrade/monorepo/chained-rules/rector-covariant-return-type.php',
        ];
    }
}
