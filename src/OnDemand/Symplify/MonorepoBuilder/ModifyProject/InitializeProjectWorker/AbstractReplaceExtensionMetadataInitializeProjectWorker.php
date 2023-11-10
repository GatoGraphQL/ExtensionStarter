<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\InitializeProjectWorker;

use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSourceAccessors\PluginDataSourceAccessor;
use PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources\PluginDataSource;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\InitializeProjectWorkerInterface;
use PoP\PoP\Extensions\Symplify\MonorepoBuilder\SmartFile\FileContentReplacerSystem;

abstract class AbstractReplaceExtensionMetadataInitializeProjectWorker implements InitializeProjectWorkerInterface
{
    /** @var string[]|null */
    private ?array $extensionSrcMetadataFiles = null;

    public function __construct(
        protected FileContentReplacerSystem $fileContentReplacerSystem,
    ) {
    }

    /**
     * @return string[]
     */
    protected function getExtensionSrcMetadataFiles(): array
    {
        if ($this->extensionSrcMetadataFiles === null) {
            $pluginDataSource = $this->getPluginDataSource();
            $pluginDataSourceAccessor = new PluginDataSourceAccessor($pluginDataSource);
            $this->extensionSrcMetadataFiles = $pluginDataSourceAccessor->getExtensionSrcMetadataFiles();
        }
        return $this->extensionSrcMetadataFiles;
    }

    protected function getPluginDataSource(): PluginDataSource
    {
        return new PluginDataSource(dirname(__DIR__, 6));
    }
}
