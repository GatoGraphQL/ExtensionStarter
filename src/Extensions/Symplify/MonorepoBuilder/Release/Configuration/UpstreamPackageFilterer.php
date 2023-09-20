<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Release\Configuration;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ValueObject\Param;
use Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\SmartFileSystem\SmartFileInfo;

final class UpstreamPackageFilterer
{
    private string $upstreamRelativePath;
    /** @var SmartFileInfo[]|null */
    private ?array $upstreamPackages = null;

    public function __construct(
        private JsonFileManager $jsonFileManager,
        private ComposerJsonProvider $composerJsonProvider,
        ParameterProvider $parameterProvider,
    ) {
        $this->upstreamRelativePath = $parameterProvider->provideStringParameter(Param::UPSTREAM_RELATIVE_PATH);
    }

    /**
     * Get all the upstream packages
     *
     * @return SmartFileInfo[]
     */
    public function getUpstreamPackages(): array
    {
        if ($this->upstreamPackages === null) {
            $packagesComposerFileInfos = $this->composerJsonProvider->getPackagesComposerFileInfos();
            $this->upstreamPackages = array_values(array_filter(
                $packagesComposerFileInfos,
                fn (SmartFileInfo $smartFileInfo) => str_starts_with($smartFileInfo->getRelativePath(), $this->upstreamRelativePath . DIRECTORY_SEPARATOR)
            ));
        }
        return $this->upstreamPackages;
    }

    /**
     * Remove all downstream packages from the list.
     *
     * @param string[] $packageNames
     * @return string[]
     */
    public function filterUpstreamPackageNames(array $packageNames): array
    {
        return array_values(array_filter(
            $packageNames,
            $this->isUpstreamPackageName(...)
        ));
    }

    public function isUpstreamPackageName(string $package): bool
    {
        $upstreamPackages = $this->getUpstreamPackages();
        foreach ($upstreamPackages as $upstreamPackage) {
            $json = $this->jsonFileManager->loadFromFileInfo($upstreamPackage);
            $packageName = $json['name'] ?? null;
            if ($package === $packageName) {
                return true;
            }
        }
        return false;
    }

    public function isUpstreamComposerFileInfo(SmartFileInfo $smartFileInfo): bool
    {
        $json = $this->jsonFileManager->loadFromFileInfo($smartFileInfo);
        $packageName = $json['name'] ?? null;
        if ($packageName === null) {
            return false;
        }
        return $this->isUpstreamPackageName($packageName);
    }

    /**
     * Remove all downstream packages from the list.
     *
     * @param SmartFileInfo[] $packagesComposerFileInfos
     * @return SmartFileInfo[]
     */
    public function filterUpstreamComposerFileInfos(array $packagesComposerFileInfos): array
    {
        return array_values(array_filter(
            $packagesComposerFileInfos,
            $this->isUpstreamComposerFileInfo(...)
        ));
    }
}
