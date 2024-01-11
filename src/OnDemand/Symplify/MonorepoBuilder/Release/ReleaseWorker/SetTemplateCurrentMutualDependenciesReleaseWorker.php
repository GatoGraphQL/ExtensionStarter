<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use PharIo\Version\Version;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\FileSystem\TemplateComposerJsonProvider;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Release\Configuration\UpstreamPackageFilterer;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Release\Configuration\UpstreamVersionResolver;
use Symplify\MonorepoBuilder\DependencyUpdater;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Package\PackageNamesProvider;
use Symplify\MonorepoBuilder\Utils\VersionUtils;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SmartFileSystem\SmartFileInfo;

final class SetTemplateCurrentMutualDependenciesReleaseWorker extends AbstractSetCurrentMutualDependenciesReleaseWorker
{
    public function __construct(
        VersionUtils $versionUtils,
        DependencyUpdater $dependencyUpdater,
        ComposerJsonProvider $composerJsonProvider,
        PackageNamesProvider $packageNamesProvider,
        ParameterProvider $parameterProvider,
        UpstreamVersionResolver $upstreamVersionResolver,
        UpstreamPackageFilterer $upstreamPackageFilterer,
        private TemplateComposerJsonProvider $templateComposerJsonProvider,
    ) {
        parent::__construct(
            $versionUtils,
            $dependencyUpdater,
            $composerJsonProvider,
            $packageNamesProvider,
            $parameterProvider,
            $upstreamVersionResolver,
            $upstreamPackageFilterer,
        );
    }

    /**
     * @return SmartFileInfo[]
     */
    protected function getPackagesComposerFileInfos(): array
    {
        return $this->templateComposerJsonProvider->getPackagesComposerFileInfos();
    }

    public function getDescription(Version $version): string
    {
        $versionInString = $this->versionUtils->getRequiredFormat($version);

        return sprintf('[Operate on templates] Set packages mutual dependencies to "%s" version', $versionInString);
    }
}
