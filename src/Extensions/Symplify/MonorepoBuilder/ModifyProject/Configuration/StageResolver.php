<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Configuration;

use Symfony\Component\Console\Input\InputInterface;
use Symplify\MonorepoBuilder\Release\Guard\ReleaseGuard;
use Symplify\MonorepoBuilder\Release\ValueObject\Stage;
use Symplify\MonorepoBuilder\ValueObject\Option;

final class StageResolver
{
    public function __construct(
        private ReleaseGuard $releaseGuard
    ) {
    }

    public function resolveFromInput(InputInterface $input): string
    {
        $stage = (string) $input->getOption(Option::STAGE);

        // empty
        if ($stage === Stage::MAIN) {
            $this->releaseGuard->guardRequiredStageOnEmptyStage();
        } else {
            $this->releaseGuard->guardStage($stage);
        }

        return $stage;
    }
}
