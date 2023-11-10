<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;

final class PrintFinalInstructionsCreateExtensionWorker implements CreateExtensionWorkerInterface
{
    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        $items = [];
        if ($inputObject->getIntegrationPluginSlug() !== '') {
            $items[] = sprintf(
                'Add a "require-dev" entry with "%s"',
                ''
            );
        }
        $description = 'We are all set! Now, please execute the following commands:';
        if ($items !== []) {
            return sprintf(
                '%s:%s%s',
                $description,
                PHP_EOL . '- ',
                implode(PHP_EOL . '- ', $items)
            );
        }
        return $description;
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        // Do nothing...
    }
}
