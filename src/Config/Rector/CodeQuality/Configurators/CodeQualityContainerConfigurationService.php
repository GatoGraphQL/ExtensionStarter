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
}
