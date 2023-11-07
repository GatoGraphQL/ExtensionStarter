<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\ModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Exception\ConfigurationException;
use Symplify\PackageBuilder\Parameter\ParameterProvider;

final class CreateExtensionGuard extends AbstractModifyProjectGuard implements CreateExtensionGuardInterface
{
    /**
     * @param CreateExtensionWorkerInterface[] $createExtensionWorkers
     */
    public function __construct(
        ParameterProvider $parameterProvider,
        private array $createExtensionWorkers
    ) {
        parent::__construct($parameterProvider);
    }

    /**
     * @return ModifyProjectWorkerInterface[]
     */
    protected function getModifyProjectWorkers(): array
    {
        return $this->createExtensionWorkers;
    }

    public function guardExtensionName(string $extensionName): void
    {
        if (empty($extensionName)) {
            throw new ConfigurationException(
                'The extension name cannot be empty'
            );
        }
    }

    /**
     * Validate theare are no forbidden characters
     *
     * @see https://stackoverflow.com/a/60470526/14402031
     */
    public function guardExtensionSlug(string $extensionSlug): void
    {
        if (!preg_match("/^[a-zA-Z_\x7f-\xff-][a-zA-Z0-9_\x7f-\xff-]*$/", $extensionSlug)) {
            throw new ConfigurationException(sprintf(
                'Extension slug "%s" is not valid',
                $extensionSlug
            ));
        }
    }

    public function guardExtensionClassName(string $extensionClassName): void
    {
        if (!$this->isPHPClassOrNamespaceNameValid($extensionClassName)) {
            throw new ConfigurationException(sprintf(
                'Extension classname "%s" is not valid',
                $extensionClassName
            ));
        }
    }
}
