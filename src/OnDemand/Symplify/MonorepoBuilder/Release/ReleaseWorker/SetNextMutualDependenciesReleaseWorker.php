<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use PharIo\Version\Version;

final class SetNextMutualDependenciesReleaseWorker extends AbstractSetNextMutualDependenciesReleaseWorker
{
    public function getDescription(Version $version): string
    {
        $versionInString = $this->versionUtils->getRequiredNextFormat($version);

        return sprintf('[Upstream fix] Set packages mutual dependencies to "%s" (alias of dev version)', $versionInString);
    }
}
