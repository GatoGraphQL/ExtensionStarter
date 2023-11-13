<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class PrintFinalInstructionsCreateExtensionWorker implements CreateExtensionWorkerInterface
{
    public function __construct(
        private SymfonyStyle $symfonyStyle
    ) {
    }
    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        return 'Print instructions to complete the creation of the extension';
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        $this->symfonyStyle->write(sprintf(
            'Please execute the following commands to complete the process:

# ------------------------------------------------

# (Git commit/push the changes to the repo)
git add . && git commit -m "Created extension: %s" && git push origin

# (Rebuild the Lando webserver for DEV)
composer rebuild-app-and-server

# (Install/activate the added plugins on the DEV webserver)
composer activate-extension-plugins

# (Install/activate the integration plugin on the PROD webserver) <= if already created
composer activate-extension-plugins-prod

# ------------------------------------------------


🎉 After executing these commands, "%s" will be ready.

Happy coding!
            ',
            $inputObject->getExtensionName(),
            $inputObject->getExtensionSlug()
        ));
    }
}
