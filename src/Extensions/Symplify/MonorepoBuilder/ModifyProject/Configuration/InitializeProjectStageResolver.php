<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Configuration;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard\ModifyProjectGuardInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard\InitializeProjectGuard;

final class InitializeProjectStageResolver extends AbstractModifyProjectStageResolver
{
    public function __construct(
        private InitializeProjectGuard $initializeProjectGuard
    ) {
    }

    protected function getModifyProjectGuard(): ModifyProjectGuardInterface
    {
        return $this->initializeProjectGuard;
    }
}
