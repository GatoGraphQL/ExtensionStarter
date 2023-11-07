<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Configuration;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard\ModifyProjectGuardInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard\CreateExtensionGuard;

final class CreateExtensionStageResolver extends AbstractModifyProjectStageResolver
{
    public function __construct(
        private CreateExtensionGuard $createExtensionGuard
    ) {
    }

    protected function getModifyProjectGuard(): ModifyProjectGuardInterface
    {
        return $this->createExtensionGuard;
    }
}
