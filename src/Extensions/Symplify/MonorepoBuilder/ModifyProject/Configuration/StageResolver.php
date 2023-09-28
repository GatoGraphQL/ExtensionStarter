<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Configuration;

use Symfony\Component\Console\Input\InputInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard\ModifyProjectGuard;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\ValueObject\Stage;
use Symplify\MonorepoBuilder\ValueObject\Option;

final class StageResolver
{
    public function __construct(
        private ModifyProjectGuard $modifyProjectGuard
    ) {
    }

    public function resolveFromInput(InputInterface $input): string
    {
        // $stage = (string) $input->getOption(Option::STAGE);
        $stage = (string) $input->getArgument(Option::STAGE);

        // empty
        if ($stage === Stage::MAIN) {
            $this->modifyProjectGuard->guardRequiredStageOnEmptyStage();
        } else {
            $this->modifyProjectGuard->guardStage($stage);
        }

        return $stage;
    }
}
