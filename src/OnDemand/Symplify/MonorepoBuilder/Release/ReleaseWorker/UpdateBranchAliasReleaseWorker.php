<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use PharIo\Version\Version;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Release\Configuration\UpstreamPackageFilterer;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Release\Configuration\UpstreamVersionResolver;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ValueObject\Param;
use Symplify\MonorepoBuilder\DevMasterAliasUpdater;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Utils\VersionUtils;
use Symplify\PackageBuilder\Parameter\ParameterProvider;

final class UpdateBranchAliasReleaseWorker implements ReleaseWorkerInterface
{
    private string $upstreamRelativePath;

    public function __construct(
        private DevMasterAliasUpdater $devMasterAliasUpdater,
        private ComposerJsonProvider $composerJsonProvider,
        private VersionUtils $versionUtils,
        ParameterProvider $parameterProvider,
        private UpstreamVersionResolver $upstreamVersionResolver,
        private UpstreamPackageFilterer $upstreamPackageFilterer,
    ) {
        $this->upstreamRelativePath = $parameterProvider->provideStringParameter(Param::UPSTREAM_RELATIVE_PATH);
    }

    public function work(Version $version): void
    {
        // Replace the $version of the monorepo root with that from the submodule
        $upstreamVersion = $this->upstreamVersionResolver->resolveVersion($this->upstreamRelativePath);

        $upstreamNextAlias = $this->versionUtils->getNextAliasFormat($upstreamVersion);

        // Only update (restore) upstream packages
        $packagesComposerFileInfos = $this->composerJsonProvider->getPackagesComposerFileInfos();
        $upstreamPackagesComposerFileInfos = $this->upstreamPackageFilterer->filterUpstreamComposerFileInfos($packagesComposerFileInfos);

        $this->devMasterAliasUpdater->updateFileInfosWithAlias(
            $upstreamPackagesComposerFileInfos,
            $upstreamNextAlias
        );
    }

    public function getDescription(Version $version): string
    {
        $nextAlias = $this->versionUtils->getNextAliasFormat($version);

        return sprintf('[Upstream fix] Set branch alias "%s" to all packages', $nextAlias);
    }
}
