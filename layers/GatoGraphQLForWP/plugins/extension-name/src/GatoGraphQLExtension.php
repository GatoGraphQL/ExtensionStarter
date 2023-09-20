<?php

declare(strict_types=1);

namespace ExtensionVendor\ExtensionName;

use PoP\Root\Module\ModuleInterface;
use GatoGraphQL\GatoGraphQL\PluginSkeleton\AbstractGatoGraphQLExtension;

class GatoGraphQLExtension extends AbstractGatoGraphQLExtension
{
    /**
     * Plugin's namespace
     */
    public final const NAMESPACE = __NAMESPACE__;

    /**
     * Add Module classes to be initialized
     *
     * @return array<class-string<ModuleInterface>> List of `Module` class to initialize
     */
    protected function getModuleClassesToInitialize(): array
    {
        return [
            Module::class,
        ];
    }

    /**
     * Dependencies on other plugins, to regenerate the schema
     * when these are activated/deactived
     *
     * @return string[]
     */
    public function getDependentOnPluginFiles(): array
    {
        return [
            'extension-wordpress-plugin/extension-wordpress-plugin-php-filename.php',
        ];
    }
}
