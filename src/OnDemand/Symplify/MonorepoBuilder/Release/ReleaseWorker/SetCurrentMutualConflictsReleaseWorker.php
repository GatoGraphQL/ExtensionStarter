<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use PharIo\Version\Version;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ConflictingRemover;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Release\Configuration\UpstreamPackageFilterer;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Release\Configuration\UpstreamVersionResolver;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ValueObject\Param;
use Symplify\MonorepoBuilder\ConflictingUpdater;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Package\PackageNamesProvider;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Utils\VersionUtils;
use Symplify\PackageBuilder\Parameter\ParameterProvider;

final class SetCurrentMutualConflictsReleaseWorker implements ReleaseWorkerInterface
{
    private string $upstreamRelativePath;

    public function __construct(
        private VersionUtils $versionUtils,
        private ComposerJsonProvider $composerJsonProvider,
        private PackageNamesProvider $packageNamesProvider,
        private ConflictingUpdater $conflictingUpdater,
        ParameterProvider $parameterProvider,
        private UpstreamVersionResolver $upstreamVersionResolver,
        private UpstreamPackageFilterer $upstreamPackageFilterer,
        private ConflictingRemover $conflictingRemover,
    ) {
        $this->upstreamRelativePath = $parameterProvider->provideStringParameter(Param::UPSTREAM_RELATIVE_PATH);
    }

    public function work(Version $version): void
    {
        // Replace the $version of the monorepo root with that from the submodule
        $upstreamVersion = $this->upstreamVersionResolver->resolveVersion($this->upstreamRelativePath);

        $packagesComposerFileInfos = $this->composerJsonProvider->getPackagesComposerFileInfos();

        // Submodule packages are the non "-pro" ones
        $packageNames = $this->packageNamesProvider->provide();
        $upstreamPackageNames = $this->upstreamPackageFilterer->filterUpstreamPackageNames($packageNames);

        $this->conflictingUpdater->updateFileInfosWithVendorAndVersion(
            $packagesComposerFileInfos,
            $upstreamPackageNames,
            $upstreamVersion
        );

        /**
         * All packages have been added under "conflict", included the ones from downstream.
         * Remove them from the upstream packages
         */
        $upstreamPackagesComposerFileInfos = $this->upstreamPackageFilterer->filterUpstreamComposerFileInfos($packagesComposerFileInfos);
        $downstreamPackageNames = array_values(array_diff($packageNames, $upstreamPackageNames));
        $this->conflictingRemover->removeFileInfosWithVendor($upstreamPackagesComposerFileInfos, $downstreamPackageNames);

        // give time to propagate printed composer.json values before commit
        sleep(1);
    }

    public function getDescription(Version $version): string
    {
        $versionInString = $this->versionUtils->getRequiredFormat($version);

        return sprintf('[Upstream fix] Set packages mutual conflicts to "%s" version', $versionInString);
    }
}
