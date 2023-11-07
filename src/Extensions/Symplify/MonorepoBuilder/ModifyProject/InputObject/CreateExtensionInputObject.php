<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject;

class CreateExtensionInputObject implements CreateExtensionInputObjectInterface
{
    public function __construct(
        // @todo Review Options for the CreateExtension command
        private string $extensionName,
        private string $extensionSlug,
        private string $extensionClassname,
    ) {
    }

    // @todo Review Options for the CreateExtension command
    public function getExtensionName(): string
    {
        return $this->extensionName;
    }

    public function getExtensionSlug(): string
    {
        return $this->extensionSlug;
    }

    public function getExtensionClassname(): string
    {
        return $this->extensionClassname;
    }
}
