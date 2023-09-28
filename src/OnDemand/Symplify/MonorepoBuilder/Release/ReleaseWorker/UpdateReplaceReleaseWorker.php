<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use PharIo\Version\Version;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Release\Configuration\UpstreamPackageFilterer;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Release\Configuration\UpstreamVersionResolver;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ValueObject\Param;
use Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SymplifyKernel\Exception\ShouldNotHappenException;

final class UpdateReplaceReleaseWorker implements ReleaseWorkerInterface
{
    private string $upstreamRelativePath;

    public function __construct(
        private ComposerJsonProvider $composerJsonProvider,
        private JsonFileManager $jsonFileManager,
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

        $rootComposerJson = $this->composerJsonProvider->getRootComposerJson();

        $replace = $rootComposerJson->getReplace();

        $newReplace = [];
        foreach (array_keys($replace) as $package) {
            $newReplace[$package] = $this->upstreamPackageFilterer->isUpstreamPackageName($package) ?
                $upstreamVersion->getVersionString()
                : $replace[$package];
        }

        if ($replace === $newReplace) {
            return;
        }

        $rootComposerJson->setReplace($newReplace);

        $rootFileInfo = $rootComposerJson->getFileInfo();
        if (! $rootFileInfo instanceof SmartFileInfo) {
            throw new ShouldNotHappenException();
        }

        $this->jsonFileManager->printJsonToFileInfo($rootComposerJson->getJsonArray(), $rootFileInfo);
    }

    public function getDescription(Version $version): string
    {
        return '[Upstream fix] Update "replace" version in "composer.json" to new tag to avoid circular dependencies conflicts';
    }
}
