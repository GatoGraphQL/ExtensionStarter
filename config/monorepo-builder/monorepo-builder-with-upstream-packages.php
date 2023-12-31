<?php

declare(strict_types=1);

use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\Configurators\ContainerConfigurationService;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurationService = new ContainerConfigurationService(
        $containerConfigurator,
        dirname(__DIR__, 2),
        'submodules/GatoGraphQL',
        true,
    );
    $containerConfigurationService->configureContainer();
};
