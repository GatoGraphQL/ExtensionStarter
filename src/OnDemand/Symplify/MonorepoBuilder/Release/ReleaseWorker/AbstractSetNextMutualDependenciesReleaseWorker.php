<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use PharIo\Version\Version;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Release\Configuration\UpstreamPackageFilterer;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Release\Configuration\UpstreamVersionResolver;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ValueObject\Param;
use Symplify\MonorepoBuilder\DependencyUpdater;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Package\PackageNamesProvider;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Utils\VersionUtils;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SmartFileSystem\SmartFileInfo;

abstract class AbstractSetNextMutualDependenciesReleaseWorker implements ReleaseWorkerInterface
{
    private string $upstreamRelativePath;

    public function __construct(
        protected ComposerJsonProvider $composerJsonProvider,
        private DependencyUpdater $dependencyUpdater,
        private PackageNamesProvider $packageNamesProvider,
        protected VersionUtils $versionUtils,
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

        $upstreamVersionInString = $this->versionUtils->getRequiredNextFormat($upstreamVersion);

        // Submodule packages are the non "-pro" ones
        $packageNames = $this->packageNamesProvider->provide();
        $upstreamPackageNames = $this->upstreamPackageFilterer->filterUpstreamPackageNames($packageNames);

        $this->dependencyUpdater->updateFileInfosWithPackagesAndVersion(
            $this->getPackagesComposerFileInfos(),
            $upstreamPackageNames,
            $upstreamVersionInString
        );
    }

    /**
     * @return SmartFileInfo[]
     */
    abstract protected function getPackagesComposerFileInfos(): array;
}
