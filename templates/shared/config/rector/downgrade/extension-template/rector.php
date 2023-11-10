<?php

declare(strict_types=1);

use PoP\ExtensionStarter\Config\Rector\Downgrade\Configurators\ExtensionTemplateContainerConfigurationService;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $containerConfigurationService = new ExtensionTemplateContainerConfigurationService(
        $rectorConfig,
        dirname(__DIR__, 4)
    );
    $containerConfigurationService->configureContainer();
};
