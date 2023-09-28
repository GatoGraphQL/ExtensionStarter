<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\InitializeProject\Contract\InitializeProjectWorker;

use PharIo\Version\Version;

interface InitializeProjectWorkerInterface
{
    /**
     * 1 line description of what this worker does, in a commanding form! e.g.:
     * - "Add new tag"
     * - "Dump new items to CHANGELOG.md"
     * - "Run coding standards"
     */
    public function getDescription(Version $version): string;

    public function work(Version $version): void;
}
