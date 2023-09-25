<?php

declare(strict_types=1);

use PoP\ExtensionStarter\Config\Rector\Downgrade\Configurators\MonorepoDowngradeContainerConfigurationService;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $containerConfigurationService = new MonorepoDowngradeContainerConfigurationService(
        $rectorConfig,
        dirname(__DIR__, 4),
        'submodules/GatoGraphQL'
    );
    $containerConfigurationService->configureContainer();
};
