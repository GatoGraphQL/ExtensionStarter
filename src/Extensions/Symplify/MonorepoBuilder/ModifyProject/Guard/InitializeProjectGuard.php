<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\InitializeProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\ModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Exception\ConfigurationException;
use Symplify\PackageBuilder\Parameter\ParameterProvider;

final class InitializeProjectGuard extends AbstractModifyProjectGuard implements InitializeProjectGuardInterface
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

    /**
     * Make sure the version input follows semver
     */
    public function guardVersion(string $version): void
    {
        if (!$this->isSemverVersion($version)) {
            throw new ConfigurationException(sprintf(
                'Version "%s" does not follow semver',
                $version
            ));
        }
    }

    public function guardPHPNamespaceOwner(string $phpNamespaceOwner): void
    {
        if (!$this->isPHPClassOrNamespaceNameValid($phpNamespaceOwner)) {
            throw new ConfigurationException(sprintf(
                'PHP namespace owner "%s" is not valid',
                $phpNamespaceOwner
            ));
        }
    }
}
