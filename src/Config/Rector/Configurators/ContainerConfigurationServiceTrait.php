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
    protected function getDownstreamBootstrapFiles(): array
    {
        return [
            $this->rootDirectory . '/stubs/wpackagist-plugin/hello-dolly/stubs.php',
        ];
    }
}
