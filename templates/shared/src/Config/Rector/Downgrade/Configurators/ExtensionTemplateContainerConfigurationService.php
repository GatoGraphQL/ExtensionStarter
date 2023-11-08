<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Rector\Downgrade\Configurators;

use PoP\PoP\Config\Rector\Downgrade\Configurators\AbstractExtensionDowngradeContainerConfigurationService;

class ExtensionTemplateContainerConfigurationService extends AbstractExtensionDowngradeContainerConfigurationService
{
    protected function getPluginRelativePath(): string
    {
        return 'layers/GatoGraphQLForWP/plugins/extension-template';
    }
}
