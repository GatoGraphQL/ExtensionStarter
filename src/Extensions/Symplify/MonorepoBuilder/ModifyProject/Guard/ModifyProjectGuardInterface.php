<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard;

interface ModifyProjectGuardInterface
{
    public function guardRequiredStageOnEmptyStage(): void;

    public function guardStage(string $stage): void;
}
