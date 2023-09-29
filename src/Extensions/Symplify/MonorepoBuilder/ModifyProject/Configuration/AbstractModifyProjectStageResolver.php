<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Configuration;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard\ModifyProjectGuardInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\ValueObject\Stage;
use Symfony\Component\Console\Input\InputInterface;
use Symplify\MonorepoBuilder\ValueObject\Option;

abstract class AbstractModifyProjectStageResolver implements ModifyProjectStageResolverInterface
{
    public function resolveFromInput(InputInterface $input): string
    {
        $stage = (string) $input->getOption(Option::STAGE);

        // empty
        if ($stage === Stage::MAIN) {
            $this->getModifyProjectGuard()->guardRequiredStageOnEmptyStage();
        } else {
            $this->getModifyProjectGuard()->guardStage($stage);
        }

        return $stage;
    }

    abstract protected function getModifyProjectGuard(): ModifyProjectGuardInterface;
}
