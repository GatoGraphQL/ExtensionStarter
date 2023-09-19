<?php

declare(strict_types=1);

use PoP\ExtensionStarter\Config\Rector\CodeQuality\Configurators\CodeQualityContainerConfigurationService;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $containerConfigurationService = new CodeQualityContainerConfigurationService(
        $rectorConfig,
        dirname(__DIR__, 3),
        'submodules/GatoGraphQL'
    );
    $containerConfigurationService->configureContainer();
};
