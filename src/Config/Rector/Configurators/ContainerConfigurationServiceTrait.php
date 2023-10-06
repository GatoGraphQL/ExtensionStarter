<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Rector\Configurators;

trait ContainerConfigurationServiceTrait
{
    /**
     * @return string[]
     */
    protected function getDownstreamProjectPaths(): array
    {
        return [
            $this->rootDirectory . '/layers/GatoGraphQLForWP/packages/*/src/*',
            $this->rootDirectory . '/layers/GatoGraphQLForWP/packages/*/tests/*',
            $this->rootDirectory . '/layers/GatoGraphQLForWP/plugins/*/src/*',
            $this->rootDirectory . '/layers/GatoGraphQLForWP/plugins/*/tests/*',
        ];
    }

    /**
     * @return string[]
     */
    protected function getBootstrapFiles(): array
    {
        /**
         * @gatographql-extension-info
         * 
         * Add stubs for all plugins for which there is an extension
         * (eg: WooCommerce, Yoast SEO or, in this case, Hello Dolly).
         *
         * This is to avoid PHPStan producing error from unexisting classes,
         * methods, constants, etc, when analyzing those packages.
         * (Eg: when calling `hello_dolly_get_lyric()` in the field resolver).
         *
         * It also avoids Rector from producing errors when downgrading
         * the code.
         *
         * @see layers/GatoGraphQLForWP/packages/hello-dolly-schema/src/FieldResolvers/ObjectType/RootObjectTypeFieldResolver.php
         *
         * The stub files, if not already available for that plugin,
         * can be generated using `php-stubs/generator`
         *
         * @see https://github.com/php-stubs/generator
         * @see https://github.com/php-stubs/wordpress-stubs
         */
        return array_merge(
            parent::getBootstrapFiles(),
            [
                $this->rootDirectory . '/stubs/wpackagist-plugin/hello-dolly/stubs.php',
            ]
        );
    }
}
