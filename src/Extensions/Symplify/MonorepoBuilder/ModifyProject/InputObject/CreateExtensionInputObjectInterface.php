<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject;

interface CreateExtensionInputObjectInterface extends ModifyProjectInputObjectInterface
{
    // @todo Review Options for the CreateExtension command
    public function getExtensionName(): string;
    public function getExtensionSlug(): string;
    public function getExtensionClassName(): string;
    public function getExtensionModuleName(): string;
}
