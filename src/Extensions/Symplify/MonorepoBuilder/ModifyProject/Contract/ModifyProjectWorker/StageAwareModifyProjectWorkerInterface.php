<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker;

interface StageAwareModifyProjectWorkerInterface extends ModifyProjectWorkerInterface
{
    /**
     * Set name of the stage, so workers can be filtered by --stage option: e.g "vendor/bin/monorepo-builder modify-project
     * v5.0.0 --stage <name>"
     */
    public function getStage(): string;
}
