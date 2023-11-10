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
        return sprintf(
            'The `create-command` has been successful.
        
To finish, please execute the following commands:

    $ git add .
    $ git commit -m "Created extension \"%s\""
    $ git push origin
    # (This will git commit and push the changes to the repo)

    $ composer rebuild-app-and-server
    # (This will rebuild the Lando Webserver for DEV, mapping the new extension)

    $ composer activate-extension-plugins
    # (This will install and activate the extension plugin, and any required integration plugin)

            ',
            $inputObject->getExtensionName()
        );
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        // Do nothing...
    }
}
