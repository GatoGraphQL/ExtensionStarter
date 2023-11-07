<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker\DuplicateTemplateFoldersCreateExtensionWorker;

class CreateExtensionWorkersDataSource
{
    /**
     * @return string[]
     */
    public function getCreateExtensionWorkerClasses(): array
    {
        return [
            // @todo Complete CreateExtension workers!!!
            DuplicateTemplateFoldersCreateExtensionWorker::class,
        ];
    }
}
