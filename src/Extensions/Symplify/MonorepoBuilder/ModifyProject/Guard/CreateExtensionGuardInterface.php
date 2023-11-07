<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard;

interface CreateExtensionGuardInterface extends ModifyProjectGuardInterface
{
    public function guardExtensionName(string $extensionName): void;
    public function guardExtensionSlug(string $extensionSlug): void;
}
