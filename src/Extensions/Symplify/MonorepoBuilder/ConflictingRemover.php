<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder;

use Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use Symplify\ComposerJsonManipulator\Printer\ComposerJsonPrinter;
use Symplify\SmartFileSystem\SmartFileInfo;

/**
 * @see \Symplify\MonorepoBuilder\Tests\ConflictingUpdater\ConflictingUpdaterTest
 */
final class ConflictingRemover
{
    public function __construct(
        private ComposerJsonFactory $composerJsonFactory,
        private ComposerJsonPrinter $composerJsonPrinter
    ) {
    }

    /**
     * @param string[] $packageNames
     * @param SmartFileInfo[] $packageComposerFileInfos
     */
    public function removeFileInfosWithVendor(
        array $packageComposerFileInfos,
        array $packageNames
    ): void {
        foreach ($packageComposerFileInfos as $packageComposerFileInfo) {
            $composerJson = $this->composerJsonFactory->createFromFileInfo($packageComposerFileInfo);
            $conflicts = $composerJson->getConflicts();

            foreach ($packageNames as $packageName) {
                // Remove entries for all downstream packages
                if (!in_array($packageName, $packageNames, true)) {
                    continue;
                }

                unset($conflicts[$packageName]);
            }

            $composerJson->setConflicts($conflicts);

            // update file
            $this->composerJsonPrinter->print($composerJson, $packageComposerFileInfo);
        }
    }
}
