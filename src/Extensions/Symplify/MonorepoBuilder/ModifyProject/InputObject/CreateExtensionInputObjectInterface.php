<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject;

interface CreateExtensionInputObjectInterface extends ModifyProjectInputObjectInterface
{
    public function getTemplate(): string;
    public function getIntegrationPluginFile(): string;
    public function getIntegrationPluginSlug(): string;
    public function getIntegrationPluginVersionConstraint(): string;
    public function getIntegrationPluginName(): string;
    public function getExtensionName(): string;
    public function getExtensionSlug(): string;
    public function getExtensionClassName(): string;
    public function getExtensionModuleName(): string;
}
