<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Utils;

use Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use Symplify\SmartFileSystem\SmartFileInfo;

final class ComposerUtils
{
    public function __construct(
        protected JsonFileManager $jsonFileManager,
    ) {
    }

    public function getComposerJSONPackageName(string $packageComposerJSONFile): string
    {
        $packageComposerJSONFileSmartFileInfo = new SmartFileInfo($packageComposerJSONFile);

        $json = $this->jsonFileManager->loadFromFileInfo($packageComposerJSONFileSmartFileInfo);

        return $json[ComposerJsonSection::NAME];
    }
}
