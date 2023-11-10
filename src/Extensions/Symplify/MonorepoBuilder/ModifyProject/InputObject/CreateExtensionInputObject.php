<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject;

class CreateExtensionInputObject implements CreateExtensionInputObjectInterface
{
    public function __construct(
        private string $template,
        private string $integrationPluginFile,
        private string $integrationPluginSlug,
        private string $integrationPluginVersionConstraint,
        private string $integrationPluginName,
        private string $extensionName,
        private string $extensionSlug,
        private string $extensionClassName,
        private string $extensionModuleName,
    ) {
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getIntegrationPluginFile(): string
    {
        return $this->integrationPluginFile;
    }

    public function getIntegrationPluginSlug(): string
    {
        return $this->integrationPluginSlug;
    }

    public function getIntegrationPluginVersionConstraint(): string
    {
        return $this->integrationPluginVersionConstraint;
    }

    public function getIntegrationPluginName(): string
    {
        return $this->integrationPluginName;
    }

    public function getExtensionName(): string
    {
        return $this->extensionName;
    }

    public function getExtensionSlug(): string
    {
        return $this->extensionSlug;
    }

    public function getExtensionClassName(): string
    {
        return $this->extensionClassName;
    }

    public function getExtensionModuleName(): string
    {
        return $this->extensionModuleName;
    }
}
