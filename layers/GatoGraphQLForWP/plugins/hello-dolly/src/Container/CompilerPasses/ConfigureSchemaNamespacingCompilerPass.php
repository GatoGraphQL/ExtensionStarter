<?php

declare(strict_types=1);

namespace MyGatoGraphQL\HelloDolly\Container\CompilerPasses;

use GatoGraphQL\GatoGraphQL\Container\CompilerPasses\AbstractConfigureSchemaNamespacingCompilerPass;
use PoP\Root\Module\ModuleInterface;

class ConfigureSchemaNamespacingCompilerPass extends AbstractConfigureSchemaNamespacingCompilerPass
{
    protected function getSchemaNamespace(): string
    {
        return 'Gato_HelloDolly';
    }

    /**
     * @return array<class-string<ModuleInterface>>
     */
    protected function getModuleClasses(): array
    {
        return [
            \MyGatoGraphQL\HelloDollySchema\Module::class,
        ];
    }
}
