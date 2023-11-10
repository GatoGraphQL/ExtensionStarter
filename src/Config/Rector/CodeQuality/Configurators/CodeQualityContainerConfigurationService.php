<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Rector\CodeQuality\Configurators;

use PoP\ExtensionStarter\Config\Rector\Configurators\ContainerConfigurationServiceTrait;
use PoP\PoP\Config\Rector\CodeQuality\Configurators\AbstractCodeQualityContainerConfigurationService;
use Rector\Config\RectorConfig;

class CodeQualityContainerConfigurationService extends AbstractCodeQualityContainerConfigurationService
{
    use ContainerConfigurationServiceTrait;

    public function __construct(
        RectorConfig $rectorConfig,
        string $rootDirectory,
        protected string $upstreamRelativeRootPath,
    ) {
        parent::__construct(
            $rectorConfig,
            $rootDirectory,
        );
    }

    /**
     * @return string[]
     */
    protected function getPaths(): array
    {
        return $this->getDownstreamProjectPaths();
    }

    /**
     * @return string[]
     */
    protected function getBootstrapFiles(): array
    {
        /**
         * @gatographql-extension-info
         *
         * Load stubs for all plugins for which there is an extension
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
            $this->getDownstreamBootstrapFiles(),
        );
    }
}
