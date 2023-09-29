<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\ModifyProjectWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\StageAwareInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Exception\ConfigurationException;
use Symplify\MonorepoBuilder\ValueObject\Option;
use Symplify\PackageBuilder\Parameter\ParameterProvider;

final class ModifyProjectGuard
{
    private bool $isStageRequired = false;

    /**
     * @var string[]
     */
    private array $stages = [];

    // /**
    //  * @var string[]
    //  */
    // private array $stagesToAllowExistingTag = [];

    /**
     * @param ModifyProjectWorkerInterface[] $modifyProjectWorkers
     */
    public function __construct(
        ParameterProvider $parameterProvider,
        // private TagResolverInterface $tagResolver,
        private array $modifyProjectWorkers
    ) {
        $this->isStageRequired = $parameterProvider->provideBoolParameter(Option::IS_STAGE_REQUIRED);
        // $this->stagesToAllowExistingTag = $parameterProvider->provideArrayParameter(
        //     Option::STAGES_TO_ALLOW_EXISTING_TAG
        // );
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

    // public function guardVersion(Version $version, string $stage): void
    // {
    //     // stage is set and it doesn't need a validation
    //     if ($stage !== Stage::MAIN && in_array($stage, $this->stagesToAllowExistingTag, true)) {
    //         return;
    //     }

    //     $this->ensureVersionIsNewerThanLastOne($version);
    // }

    /**
     * @return string[]
     */
    private function getStages(): array
    {
        if ($this->stages !== []) {
            return $this->stages;
        }

        $stages = [];
        foreach ($this->modifyProjectWorkers as $modifyProjectWorker) {
            if ($modifyProjectWorker instanceof StageAwareInterface) {
                $stages[] = $modifyProjectWorker->getStage();
            }
        }

        $this->stages = array_unique($stages);

        return $this->stages;
    }

    // private function ensureVersionIsNewerThanLastOne(Version $version): void
    // {
    //     $mostRecentVersion = $this->tagResolver->resolve(getcwd());

    //     // no tag yet
    //     if ($mostRecentVersion === null) {
    //         return;
    //     }

    //     // normalize to workaround phar-io bug
    //     $mostRecentVersion = strtolower($mostRecentVersion);

    //     // validation
    //     $mostRecentVersion = new Version($mostRecentVersion);
    //     if ($version->isGreaterThan($mostRecentVersion)) {
    //         return;
    //     }

    //     throw new InvalidGitVersionException(sprintf(
    //         'Provided version "%s" must be greater than the last one: "%s"',
    //         $version->getVersionString(),
    //         $mostRecentVersion->getVersionString()
    //     ));
    // }
}
