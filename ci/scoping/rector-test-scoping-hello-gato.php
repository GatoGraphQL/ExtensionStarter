<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

require_once dirname(__DIR__, 2) . '/submodules/GatoGraphQL/ci/scoping/rector-test-scoping-shared.php';

/**
 * This Rector configuration imports the fully qualified classnames
 * using `use`, and removing it from the body.
 * Rule `AndAssignsToSeparateLinesRector` is not needed, but we need
 * to run at least 1 rule.
 */
return static function (RectorConfig $rectorConfig): void {
    // Shared configuration
    doCommonContainerConfiguration($rectorConfig);

    $monorepoDir = dirname(__DIR__, 2);
    $pluginDir = $monorepoDir . '/layers/GatoGraphQLForWP/plugins/hello-gato';

    // Rector relies on autoload setup of your project; Composer autoload is included by default; to add more:
    $rectorConfig->bootstrapFiles([
        $pluginDir . '/vendor/scoper-autoload.php',
    ]);

    // files to rector
    $rectorConfig->paths([
        $pluginDir . '/vendor',
    ]);

    // files to skip
    $rectorConfig->skip([
        '*/tests/*',
    ]);
};
