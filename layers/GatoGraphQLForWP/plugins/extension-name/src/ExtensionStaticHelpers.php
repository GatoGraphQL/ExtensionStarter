<?php

declare(strict_types=1);

namespace DollyShepherd\HelloDolly;

use GatoGraphQL\GatoGraphQL\PluginApp;
use GatoGraphQL\GatoGraphQL\StaticHelpers\PluginVersionHelpers;

class ExtensionStaticHelpers
{
    public static function getGitHubRepoDocsRootPathURL(): string
    {
        // @todo Complete for Hello Dolly!
        $gitDevelopmentBranch = 'main';
        
        $extensionPluginVersion = PluginApp::getExtension(GatoGraphQLExtension::class)->getPluginVersion();
        $tag = PluginVersionHelpers::isDevelopmentVersion($extensionPluginVersion)
            ? $gitDevelopmentBranch
            : $extensionPluginVersion;
        return 'https://raw.githubusercontent.com/GatoGraphQL/ExtensionStarter/' . $tag . '/layers/GatoGraphQLForWP/plugins/extension-name/';
    }
}
