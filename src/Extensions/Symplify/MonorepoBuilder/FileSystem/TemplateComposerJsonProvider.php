<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\FileSystem;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Finder\TemplatePackageComposerFinder;
use Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SymplifyKernel\Exception\ShouldNotHappenException;

/**
 * This class is a copy/paste from:
 * Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider
 */
final class TemplateComposerJsonProvider
{
    public function __construct(
        private JsonFileManager $jsonFileManager,
        private TemplatePackageComposerFinder $packageComposerFinder,
        private ComposerJsonFactory $composerJsonFactory
    ) {
    }

    /**
     * @return SmartFileInfo[]
     */
    public function getPackagesComposerFileInfos(): array
    {
        return $this->packageComposerFinder->getPackageComposerFiles();
    }

    /**
     * @return SmartFileInfo[]
     */
    public function getRootAndPackageFileInfos(): array
    {
        return array_merge(
            $this->getPackagesComposerFileInfos(),
            [$this->packageComposerFinder->getRootPackageComposerFile()]
        );
    }

    /**
     * @return ComposerJson[]
     */
    public function getPackageComposerJsons(): array
    {
        $packageComposerJsons = [];
        foreach ($this->getPackagesComposerFileInfos() as $packagesComposerFileInfo) {
            $packageComposerJsons[] = $this->composerJsonFactory->createFromFileInfo($packagesComposerFileInfo);
        }

        return $packageComposerJsons;
    }

    /**
     * @return string[]
     */
    public function getPackageNames(): array
    {
        $packageNames = [];
        foreach ($this->getPackagesComposerFileInfos() as $packagesComposerFileInfo) {
            $packageComposerJson = $this->composerJsonFactory->createFromFileInfo($packagesComposerFileInfo);
            $packageName = $packageComposerJson->getName();
            if (! is_string($packageName)) {
                continue;
            }

            $packageNames[] = $packageName;
        }

        return $packageNames;
    }

    public function getPackageFileInfoByName(string $packageName): SmartFileInfo
    {
        foreach ($this->getPackagesComposerFileInfos() as $packagesComposerFileInfo) {
            $json = $this->jsonFileManager->loadFromFileInfo($packagesComposerFileInfo);
            if (! isset($json['name'])) {
                continue;
            }

            if ($json['name'] !== $packageName) {
                continue;
            }

            return $packagesComposerFileInfo;
        }

        throw new ShouldNotHappenException();
    }

    public function getRootComposerJson(): ComposerJson
    {
        $rootFileInfo = $this->packageComposerFinder->getRootPackageComposerFile();
        return $this->composerJsonFactory->createFromFileInfo($rootFileInfo);
    }
}
