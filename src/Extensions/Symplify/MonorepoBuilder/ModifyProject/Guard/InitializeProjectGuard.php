<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\InitializeProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\ModifyProjectWorkerInterface;
use Symplify\PackageBuilder\Parameter\ParameterProvider;

final class InitializeProjectGuard extends AbstractModifyProjectGuard
{
    /**
     * @param InitializeProjectWorkerInterface[] $initializeProjectWorkers
     */
    public function __construct(
        ParameterProvider $parameterProvider,
        private array $initializeProjectWorkers
    ) {
        parent::__construct($parameterProvider);
    }

    /**
     * @return ModifyProjectWorkerInterface[]
     */
    protected function getModifyProjectWorkers(): array
    {
        return $this->initializeProjectWorkers;
    }
}
