<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;

trait CreateExtensionWorkerTrait
{
    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    protected function getIntegrationPluginWPackagistDependency(CreateExtensionInputObjectInterface $inputObject): string
    {
        return "wpackagist-plugin/{$inputObject->getIntegrationPluginSlug()}";
    }
}
