<?php

declare(strict_types=1);

namespace DollyShepherd\HelloDolly;

use PoP\Root\Module\ModuleInterface;
use GatoGraphQL\GatoGraphQL\PluginSkeleton\AbstractExtensionModule;

class Module extends AbstractExtensionModule
{
    /**
     * @return array<class-string<ModuleInterface>>
     */
    public function getDependedModuleClasses(): array
    {
        return [
            \DollyShepherd\HelloDollySchema\Module::class,
        ];
    }
}