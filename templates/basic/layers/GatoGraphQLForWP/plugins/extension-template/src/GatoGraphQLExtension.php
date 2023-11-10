<?php

declare(strict_types=1);

namespace MyCompanyForGatoGraphQL\ExtensionTemplate;

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
        /**
         * @gatographql-extension-info
         *
         * If the extension is an integration for some plugin (eg: WooCommerce,
         * Yoast SEO or, in this case, Extension Template), add below the plugin's main file
         */
        $requiredPluginFile = 'extension-template/extension-template.php';
        if ($requiredPluginFile !== '') {
            return [
                $requiredPluginFile,
            ];
        }
        /** @phpstan-ignore-next-line */
        return parent::getDependentOnPluginFiles();
    }
}
