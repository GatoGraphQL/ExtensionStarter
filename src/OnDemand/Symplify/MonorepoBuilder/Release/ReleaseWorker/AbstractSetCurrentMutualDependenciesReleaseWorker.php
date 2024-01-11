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

abstract class AbstractSetCurrentMutualDependenciesReleaseWorker implements ReleaseWorkerInterface
{
    protected string $upstreamRelativePath;

    public function __construct(
        protected VersionUtils $versionUtils,
        private DependencyUpdater $dependencyUpdater,
        protected ComposerJsonProvider $composerJsonProvider,
        private PackageNamesProvider $packageNamesProvider,
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

        $upstreamVersionInString = $this->versionUtils->getRequiredFormat($upstreamVersion);

        // Submodule packages are the non "-pro" ones
        $packageNames = $this->packageNamesProvider->provide();
        $upstreamPackageNames = $this->upstreamPackageFilterer->filterUpstreamPackageNames($packageNames);

        $this->dependencyUpdater->updateFileInfosWithPackagesAndVersion(
            $this->composerJsonProvider->getPackagesComposerFileInfos(),
            $upstreamPackageNames,
            $upstreamVersionInString
        );

        // give time to propagate values before commit
        sleep(1);
    }

    /**
     * @return SmartFileInfo[]
     */
    abstract protected function getPackagesComposerFileInfos(): array;
}
