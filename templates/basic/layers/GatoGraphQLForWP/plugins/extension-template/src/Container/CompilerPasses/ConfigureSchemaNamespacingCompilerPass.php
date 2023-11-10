<?php

declare(strict_types=1);

namespace MyCompanyForGatoGraphQL\ExtensionTemplate\Container\CompilerPasses;

use GatoGraphQL\GatoGraphQL\Container\CompilerPasses\AbstractConfigureSchemaNamespacingCompilerPass;
use PoP\Root\Module\ModuleInterface;

class ConfigureSchemaNamespacingCompilerPass extends AbstractConfigureSchemaNamespacingCompilerPass
{
    protected function getSchemaNamespace(): string
    {
        return 'MyCompanyForGatoGraphQL';
    }

    /**
     * @return array<class-string<ModuleInterface>>
     */
    protected function getModuleClasses(): array
    {
        return [
            \MyCompanyForGatoGraphQL\ExtensionTemplateSchema\Module::class,
        ];
    }
}
