<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard;

use PharIo\Version\InvalidVersionException;
use PharIo\Version\Version;
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

    // @todo CreateExtension guard
    // /**
    //  * Make sure the version input follows semver
    //  */
    // public function guardVersion(string $version): void
    // {
    //     try {
    //         new Version($version);
    //     } catch (InvalidVersionException $e) {
    //         throw new ConfigurationException(sprintf(
    //             'Version "%s" does not follow semver',
    //             $version
    //         ));
    //     }
    // }

    // /**
    //  * Validate theare are no spaces or forbidden characters
    //  *
    //  * @see https://stackoverflow.com/a/60470526/14402031
    //  */
    // public function guardPHPNamespaceOwner(string $phpNamespaceOwner): void
    // {
    //     if (!preg_match("/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/", $phpNamespaceOwner)) {
    //         throw new ConfigurationException(sprintf(
    //             'PHP namespace owner "%s" is not valid',
    //             $phpNamespaceOwner
    //         ));
    //     }
    // }
}
