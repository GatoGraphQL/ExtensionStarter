<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Rector\Downgrade\Configurators;

use PoP\ExtensionStarter\Config\Rector\Configurators\ContainerConfigurationServiceTrait;
use PoP\PoP\Config\Rector\Downgrade\Configurators\MonorepoDowngradeContainerConfigurationService as UpstreamMonorepoDowngradeContainerConfigurationService;
use Rector\Config\RectorConfig;

class MonorepoDowngradeContainerConfigurationService extends UpstreamMonorepoDowngradeContainerConfigurationService
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
    protected function getBootstrapFiles(): array
    {
        /**
         * @gatographql-extension-info
         *
         * Load stubs for all plugins for which there is an extension
         * (eg: WooCommerce, Yoast SEO or, in this case, Hello Dolly).
         *
         * @see src/Config/Rector/Configurators/ContainerConfigurationServiceTrait.php
         */
        return array_merge(
            parent::getBootstrapFiles(),
            $this->getDownstreamBootstrapFiles(),
        );
    }
}
