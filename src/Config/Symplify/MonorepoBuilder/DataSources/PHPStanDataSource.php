<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources\PHPStanDataSource as UpstreamPHPStanDataSource;

class PHPStanDataSource extends UpstreamPHPStanDataSource
{
    public function __construct(
        protected string $upstreamRelativeRootPath
    ) {
    }
}
