<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use PharIo\Version\Version;
use Symplify\SmartFileSystem\SmartFileInfo;

final class SetNextMutualDependenciesReleaseWorker extends AbstractSetNextMutualDependenciesReleaseWorker
{
    /**
     * @return SmartFileInfo[]
     */
    protected function getPackagesComposerFileInfos(): array
    {
        return $this->composerJsonProvider->getPackagesComposerFileInfos();
    }

    public function getDescription(Version $version): string
    {
        $versionInString = $this->versionUtils->getRequiredNextFormat($version);

        return sprintf('[Upstream fix] Set packages mutual dependencies to "%s" (alias of dev version)', $versionInString);
    }
}
