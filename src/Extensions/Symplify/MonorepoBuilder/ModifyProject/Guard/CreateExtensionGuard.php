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

    /**
     * Make sure the plugin file is valid
     */
    public function guardIntegrationPluginFile(string $file): void
    {
        if (!preg_match('#^(\w+/){1,2}\w+\.php$#', $file)) {
            throw new ConfigurationException(sprintf(
                'Plugin file "%s" is not valid',
                $file
            ));
        }
    }

    // /**
    //  * Make sure the version input follows semver
    //  */
    // public function guardIntegrationPluginVersionConstraint(string $version): void
    // {
    //     if ($version === '*') {
    //         return;
    //     }
    //     if (!$this->isSemverVersion($version)) {
    //         throw new ConfigurationException(sprintf(
    //             'Version "%s" does not follow semver',
    //             $version
    //         ));
    //     }
    // }

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
