<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\InitializeProjectWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\InitializeProjectWorkerInterface;
use PoP\PoP\Extensions\Symplify\MonorepoBuilder\SmartFile\FileContentReplacerSystem;

abstract class AbstractReplaceMonorepoMetadataInitializeProjectWorker implements InitializeProjectWorkerInterface
{
    protected string $monorepoMetadataFile;

    public function __construct(
        protected FileContentReplacerSystem $fileContentReplacerSystem,
    ) {
        $this->monorepoMetadataFile = $this->getMonorepoMetadataFile();
    }

    protected function getMonorepoMetadataFile(): string
    {
        return dirname(__DIR__, 6) . '/src/Monorepo/MonorepoMetadata.php';
    }
}
