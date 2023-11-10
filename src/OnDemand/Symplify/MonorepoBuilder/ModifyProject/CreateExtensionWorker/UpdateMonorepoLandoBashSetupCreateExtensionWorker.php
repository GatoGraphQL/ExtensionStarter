<?php

declare(strict_types=1);

namespace PoP\ExtensionStarter\OnDemand\Symplify\MonorepoBuilder\ModifyProject\CreateExtensionWorker;

use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\Contract\ModifyProjectWorker\CreateExtensionWorkerInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\CreateExtensionInputObjectInterface;
use PoP\ExtensionStarter\Extensions\Symplify\MonorepoBuilder\ModifyProject\InputObject\ModifyProjectInputObjectInterface;
use Symplify\SmartFileSystem\SmartFileInfo;
use Symplify\SmartFileSystem\SmartFileSystem;

class UpdateMonorepoLandoBashSetupCreateExtensionWorker implements CreateExtensionWorkerInterface
{
    public function __construct(
        private SmartFileSystem $smartFileSystem,
    ) {
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function getDescription(ModifyProjectInputObjectInterface $inputObject): string
    {
        $items = [];
        if ($inputObject->getIntegrationPluginSlug() !== '') {
            $items[] = sprintf(
                'Install integration plugin "%s" in the webservers',
                $inputObject->getIntegrationPluginName()
            );
        }
        $description = 'Update the monorepo\'s Lando webserver .sh setup files';
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
     * Check there's an integration plugin required, otherwise
     * nothing to do.
     *
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    public function work(ModifyProjectInputObjectInterface $inputObject): void
    {
        if ($inputObject->getIntegrationPluginSlug() === '') {
            return;
        }

        // DEV server
        $this->installIntegrationPluginInLandoWebserver($inputObject, false);

        // PROD server
        $this->installIntegrationPluginInLandoWebserver($inputObject, true);
    }

    /**
     * @param CreateExtensionInputObjectInterface $inputObject
     */
    protected function installIntegrationPluginInLandoWebserver(
        CreateExtensionInputObjectInterface $inputObject,
        bool $isProd,
    ): void {
        $landoWebserverActivatePluginsBashFile = $this->getLandoWebserverActivatePluginsBashFile($isProd);

        $landoWebserverActivatePluginsBashFileSmartFileInfo = new SmartFileInfo($landoWebserverActivatePluginsBashFile);

        $landoWebserverActivatePluginsBashContent = $landoWebserverActivatePluginsBashFileSmartFileInfo->getContents();

        // Append the content
        $landoWebserverActivatePluginsBashContent .= $this->getActivatePluginsBashContentToAppend($inputObject, $isProd);

        $this->smartFileSystem->dumpFile($landoWebserverActivatePluginsBashFile, $landoWebserverActivatePluginsBashContent);
    }

    protected function getLandoWebserverActivatePluginsBashFile(bool $isProd): string
    {
        $rootFolder = dirname(__DIR__, 6);
        return $rootFolder . '/webservers/gatographql-extensions' . ($isProd ? '-for-prod' : '') . '/setup-extensions/activate-plugins.sh';
    }

    protected function getActivatePluginsBashContentToAppend(
        CreateExtensionInputObjectInterface $inputObject,
        bool $isProd,
    ): string {
        $extensionSlug = $inputObject->getExtensionSlug();
        $extensionName = $inputObject->getExtensionName();

        $content = '';
        if ($inputObject->getIntegrationPluginSlug() !== '') {
            $integrationPluginSlug = $inputObject->getIntegrationPluginSlug();
            $content = <<<BASH
            
            # Download and maybe activate external plugins
            if wp plugin is-installed $integrationPluginSlug; then
                wp plugin activate $integrationPluginSlug
            else
                wp plugin install $integrationPluginSlug --activate
            fi

            BASH;
        }

        if ($isProd) {
            $content .= <<<BASH

            # Activate own plugins
            if wp plugin is-installed gatographql-$extensionSlug; then
                wp plugin activate gatographql-$extensionSlug
            else
                echo "Please download the latest PROD version of the 'Gato GraphQL - $extensionName' plugin from your GitHub repo, and install it on this WordPress site"
            fi

            BASH;
        } else {
            $content .= <<<BASH

            # Activate own plugins
            wp plugin activate gatographql-$extensionSlug

            BASH;
        }

        return $content;
    }
}
