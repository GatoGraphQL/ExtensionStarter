<?php

declare(strict_types=1);

namespace DollyShepherd\ExtensionName\Container\CompilerPasses;

use GatoGraphQL\GatoGraphQL\Container\CompilerPasses\AbstractConfigureSchemaNamespacingCompilerPass;
use PoP\Root\Module\ModuleInterface;

class ConfigureSchemaNamespacingCompilerPass extends AbstractConfigureSchemaNamespacingCompilerPass
{
    protected function getSchemaNamespace(): string
    {
        return 'Gato_ExtensionName';
    }

    /**
     * @return array<class-string<ModuleInterface>>
     */
    protected function getModuleClasses(): array
    {
        return [
            \DollyShepherd\ExtensionNameSchema\Module::class,
        ];
    }
}
