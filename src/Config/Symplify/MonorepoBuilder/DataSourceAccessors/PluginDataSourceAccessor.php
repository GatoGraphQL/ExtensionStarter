<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSourceAccessors;

use PoP\PoP\Config\Symplify\MonorepoBuilder\DataSourceAccessors\PluginDataSourceAccessor as UpstreamPluginDataSourceAccessor;

class PluginDataSourceAccessor extends UpstreamPluginDataSourceAccessor
{
    /**
     * @return string[]
     */
    public function getExtensionSrcMetadataFiles(): array
    {
        $files = [];
        foreach ($this->pluginDataSource->getPluginConfigEntries() as $pluginConfigEntry) {
            $srcExtensionMetadataFile = $this->pluginDataSource->getRootDir() . '/' . $pluginConfigEntry['path'] . '/src/ExtensionMetadata.php';
            if (!file_exists($srcExtensionMetadataFile)) {
                continue;
            }
            $files[] = $srcExtensionMetadataFile;
        }
        return $files;
    }
}
