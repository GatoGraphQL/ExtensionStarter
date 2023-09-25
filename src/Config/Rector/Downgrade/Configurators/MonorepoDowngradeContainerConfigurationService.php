<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Rector\Downgrade\Configurators;

use PoP\PoP\Config\Rector\Downgrade\Configurators\MonorepoDowngradeContainerConfigurationService as UpstreamMonorepoDowngradeContainerConfigurationService;
use Rector\Config\RectorConfig;

class MonorepoDowngradeContainerConfigurationService extends UpstreamMonorepoDowngradeContainerConfigurationService
{
    public function __construct(
        RectorConfig $rectorConfig,
        string $rootDirectory,
        protected string $upstreamRelativeRootPath,
    ) {
        parent::__construct(
            $rectorConfig,
            $rootDirectory,
        );
    }
}
