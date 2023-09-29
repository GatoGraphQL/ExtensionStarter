<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\ModifyProjectWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\InitializeProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\InitializeProjectInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Worker\AbstractGuardOnDefaultBranchWorker;

final class GuardOnDefaultBranchModifyProjectWorker extends AbstractGuardOnDefaultBranchWorker implements InitializeProjectWorkerInterface
{
    /**
     * @param InitializeProjectInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        $this->doWork();
    }

    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        return $this->doGetDescription();
    }
}
