<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard;

use PharIo\Version\InvalidVersionException;
use PharIo\Version\Version;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\ModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\StageAwareModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Exception\ConfigurationException;
use Symplify\MonorepoBuilder\ValueObject\Option;
use Symplify\PackageBuilder\Parameter\ParameterProvider;

abstract class AbstractModifyProjectGuard implements ModifyProjectGuardInterface
{
    private bool $isStageRequired = false;

    /**
     * @var string[]
     */
    private array $stages = [];

    public function __construct(
        ParameterProvider $parameterProvider,
    ) {
        $this->isStageRequired = $parameterProvider->provideBoolParameter(Option::IS_STAGE_REQUIRED);
    }

    public function guardRequiredStageOnEmptyStage(): void
    {
        // there are no stages → nothing to filter by
        if ($this->getStages() === []) {
            return;
        }

        // stage is optional → all right
        if (! $this->isStageRequired) {
            return;
        }

        // stage is required → show options
        throw new ConfigurationException(sprintf(
            'Set "--%s <name>" option first. Pick one of: "%s"',
            Option::STAGE,
            implode('", "', $this->getStages())
        ));
    }

    public function guardStage(string $stage): void
    {
        // stage is correct
        if (in_array($stage, $this->getStages(), true)) {
            return;
        }

        // stage has invalid value
        throw new ConfigurationException(sprintf(
            'Stage "%s" was not found. Pick one of: "%s"',
            $stage,
            implode('", "', $this->getStages())
        ));
    }

    /**
     * @return string[]
     */
    private function getStages(): array
    {
        if ($this->stages !== []) {
            return $this->stages;
        }

        $stages = [];
        foreach ($this->getModifyProjectWorkers() as $modifyProjectWorker) {
            if ($modifyProjectWorker instanceof StageAwareModifyProjectWorkerInterface) {
                $stages[] = $modifyProjectWorker->getStage();
            }
        }

        $this->stages = array_unique($stages);

        return $this->stages;
    }

    /**
     * @return ModifyProjectWorkerInterface[]
     */
    abstract protected function getModifyProjectWorkers(): array;

    /**
     * Validate theare are no spaces or forbidden characters
     * in the classname or namespace
     *
     * @see https://stackoverflow.com/a/60470526/14402031
     */
    protected function isPHPClassOrNamespaceNameValid(string $phpClassOrNamespaceName): bool
    {
        return preg_match("/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/", $phpClassOrNamespaceName) === 1;
    }

    protected function isSemverVersion(string $version): bool
    {
        try {
            new Version($version);
        } catch (InvalidVersionException $e) {
            return false;
        }
        return true;
    }
}
