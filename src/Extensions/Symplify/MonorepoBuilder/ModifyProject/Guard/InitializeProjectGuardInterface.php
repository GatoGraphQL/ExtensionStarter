<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Guard;

interface InitializeProjectGuardInterface extends ModifyProjectGuardInterface
{
    public function guardVersion(string $version): void;
    public function guardPHPNamespaceOwner(string $phpNamespaceOwner): void;
}
