<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use PharIo\Version\Version;

final class SetCurrentMutualDependenciesReleaseWorker extends AbstractSetCurrentMutualDependenciesReleaseWorker
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
        $versionInString = $this->versionUtils->getRequiredFormat($version);

        return sprintf('[Upstream fix] Set packages mutual dependencies to "%s" version', $versionInString);
    }
}
