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
            'The `create-command` has been successful.
        
To finish, please execute the following commands:

# ✅ Git commit and push the changes to the repo:
# ------------------------------------------------
git add .
git commit -m "Created extension: %s"
git push origin

# ✅ Rebuild the Lando Webserver for DEV, mapping the new extension:
# ------------------------------------------------
composer rebuild-app-and-server

# ✅ Install/activate the added plugin (DEV and PROD webservers):
# ------------------------------------------------
composer activate-extension-plugins
composer activate-extension-plugins-prod

🎉 Extension "%s" is now ready. Happy coding!
            ',
            $inputObject->getExtensionName(),
            $inputObject->getExtensionSlug()
        ));
    }
}
