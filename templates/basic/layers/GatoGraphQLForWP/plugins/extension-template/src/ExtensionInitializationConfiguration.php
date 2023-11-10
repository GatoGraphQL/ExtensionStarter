<?php

declare(strict_types=1);

namespace MyCompanyForGatoGraphQL\ExtensionTemplate;

use MyCompanyForGatoGraphQL\ExtensionTemplate\ModuleResolvers\SchemaTypeModuleResolver;
use GatoGraphQL\GatoGraphQL\PluginSkeleton\AbstractExtensionInitializationConfiguration;
use PoP\Root\Module\ModuleInterface;

class ExtensionInitializationConfiguration extends AbstractExtensionInitializationConfiguration
{
    /**
     * Provide the list of modules to check if they are enabled and,
     * if they are not, what component classes must skip initialization
     *
     * @return array<string,array<class-string<ModuleInterface>>>
     */
    protected function getModuleClassesToSkipIfModuleDisabled(): array
    {
        return [
            SchemaTypeModuleResolver::SCHEMA_EXTENSION_TEMPLATE => [
                \MyCompanyForGatoGraphQL\ExtensionTemplateSchema\Module::class,
            ],
        ];
    }
}
