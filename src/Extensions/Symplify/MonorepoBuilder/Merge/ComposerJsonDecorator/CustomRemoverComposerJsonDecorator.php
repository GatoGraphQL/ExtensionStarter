<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\Merge\ComposerJsonDecorator;

use Symplify\ComposerJsonManipulator\ValueObject\ComposerJson;
use Symplify\MonorepoBuilder\Merge\Configuration\ModifyingComposerJsonProvider;
use Symplify\MonorepoBuilder\Merge\Contract\ComposerJsonDecoratorInterface;

/**
 * It removes entries under 'require'.
 *
 * @deprecated This class is currently not needed
 */
final class CustomRemoverComposerJsonDecorator implements ComposerJsonDecoratorInterface
{
    public function __construct(
        private ModifyingComposerJsonProvider $modifyingComposerJsonProvider
    ) {
    }

    public function decorate(ComposerJson $composerJson): void
    {
        $removingComposerJson = $this->modifyingComposerJsonProvider->getRemovingComposerJson();
        if (! $removingComposerJson instanceof ComposerJson) {
            return;
        }

        $this->processReplace($composerJson, $removingComposerJson);
    }

    private function processReplace(ComposerJson $composerJson, ComposerJson $composerJsonToRemove): void
    {
        if ($composerJsonToRemove->getReplace() === []) {
            return;
        }
        $currentReplace = $composerJson->getReplace();
        $packages = array_keys($composerJsonToRemove->getReplace());
        foreach ($packages as $package) {
            unset($currentReplace[$package]);
        }

        $composerJson->setReplace($currentReplace);
    }
}
