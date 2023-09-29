<?php

declare(strict_types=1);

namespace DollyShepherd\HelloDolly;

use GatoGraphQL\GatoGraphQL\PluginApp;
use GatoGraphQL\GatoGraphQL\StaticHelpers\PluginVersionHelpers;

class ExtensionStaticHelpers
{
    public static function getGitHubRepoDocsRootURL(): string
    {
        return 'https://raw.githubusercontent.com/GatoGraphQL/ExtensionStarter';
    }

    public static function getGitHubRepoDocsRootPathURL(): string
    {
        $extensionPluginVersion = PluginApp::getExtension(GatoGraphQLExtension::class)->getPluginVersion();
        $tag = PluginVersionHelpers::isDevelopmentVersion($extensionPluginVersion)
            ? 'main'
            : $extensionPluginVersion;
        return static::getGitHubRepoDocsRootURL() . '/' . $tag . '/layers/GatoGraphQLForWP/plugins/hello-dolly/';
    }
}
