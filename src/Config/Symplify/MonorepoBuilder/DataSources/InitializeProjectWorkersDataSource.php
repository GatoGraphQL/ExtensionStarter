<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\InitializeProjectWorker\ReplaceExtensionMetadataInitializeProjectWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\InitializeProjectWorker\ReplaceMonorepoMetadataInitializeProjectWorker;
use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\InitializeProjectWorker\SearchAndReplaceInitialTextInCodebaseInitializeProjectWorker;

class InitializeProjectWorkersDataSource
{
    /**
     * @return string[]
     */
    public function getInitializeProjectWorkerClasses(): array
    {
        return [
            ReplaceMonorepoMetadataInitializeProjectWorker::class,
            ReplaceExtensionMetadataInitializeProjectWorker::class,
            /**
             * Notice that there is no need for this worker currently,
             * because there are no blocks in the extension demo.
             *
             * If there were, then this worker should be created,
             * to replace the metadata in file:
             *
             *   - `extension-metadata.config.js`
             */
            // ReplaceWebpackConfigMetadataInitializeProjectWorker::class,
            SearchAndReplaceInitialTextInCodebaseInitializeProjectWorker::class,
        ];
    }
}
