<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard;

interface CreateExtensionGuardInterface extends ModifyProjectGuardInterface
{
    public function guardIntegrationPluginFile(string $file): void;
    // public function guardIntegrationPluginVersionConstraint(string $version): void;
    public function guardExtensionSlug(string $extensionSlug): void;
    public function guardExtensionClassName(string $extensionClassName): void;
}
