<?php

declare(strict_types=1);

use Isolated\Symfony\Component\Finder\Finder;

/**
 * @see submodules/GatoGraphQL/ci/scoping/scoper-gatographql.inc.php
 */
function convertRelativeToFullPath(string $relativePath): string
{
    $monorepoDir = dirname(__DIR__, 2);
    $pluginDir = $monorepoDir . '/layers/GatoGraphQLForWP/plugins';
    return $pluginDir . '/' . $relativePath;
}

return [
    'prefix' => 'PrefixedDollyShepherd',
    'finders' => [
        // Scope packages under vendor/, excluding local WordPress packages
        Finder::create()
            ->files()
            ->ignoreVCS(true)
            ->notName('/.*\\.md|.*\\.dist|composer\\.lock/')
            ->exclude([
                'tests',
            ])
            ->notPath([
                // Exclude all composer.json from own libraries (they get broken!)
                '#[dolly\-shepherd]/*/composer.json#',
                // // Exclude all libraries for WordPress: Packages ending in "-wp"
                // '#[dolly\-shepherd]/[a-zA-Z0-9_-]*-wp/#',
                // ...
                // Exclude libraries
                // ...
            ])
            ->in([
                convertRelativeToFullPath('hello-dolly/vendor'),
            ]),
    ],
    'exclude-namespaces' => [
        // Own namespaces from the ExtensionStarter
        'DollyShepherd',
        
        // Own namespaces (from the Gato GraphQL plugin)
        'PoPAPI',
        'PoPBackbone',
        'PoPCMSSchema',
        'PoPSchema',
        'PoPWPSchema',
        'PoP',
        'GraphQLByPoP',
        'GatoGraphQL',
    ],
];
