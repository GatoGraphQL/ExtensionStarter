<?php
/*
Plugin Name: Gato GraphQL - Hello Dolly
Plugin URI:
Description: Integration of plugin Hello Dolly with Gato GraphQL
Version: 1.1.0-dev
Requires at least: 5.4
Requires PHP: 8.1
Author: My Company
License:
License URI:
Text Domain: gatographql-hello-dolly
Domain Path: /languages
*/

use MyCompanyForGatoGraphQL\HelloDolly\GatoGraphQLExtension;
use GatoGraphQL\GatoGraphQL\Plugin;
use GatoGraphQL\GatoGraphQL\PluginApp;
use GatoGraphQL\GatoGraphQL\PluginStaticHelpers;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

\add_action('init', function (): void {
    load_plugin_textdomain('gatographql-hello-dolly', false, plugin_basename(__FILE__) . '/languages');
});

/**
 * Create and set-up the extension
 */
add_action(
    'plugins_loaded',
    function (): void {
        /**
         * @gatographql-extension-info
         *
         * Extension's name and version.
         *
         * Use a stability suffix as supported by Composer.
         *
         * @see https://getcomposer.org/doc/articles/versions.md#stabilities
         * 
         * Important: Do not modify the formatting of this PHP code!
         * A regex will search for this exact pattern, to update the
         * version in the ReleaseWorker when deploying for PROD.
         *
         * @see submodules/GatoGraphQL/src/OnDemand/Symplify/MonorepoBuilder/Release/ReleaseWorker/ConvertVersionForProdInPluginMainFileReleaseWorker.php
         *
         * @gatographql-readonly-code
         */
        $extensionVersion = '1.1.0-dev';
        $extensionName = \__('Gato GraphQL - Hello Dolly', 'gatographql-hello-dolly');
        /**
         * @gatographql-extension-info
         *
         * The minimum version required from the Gato GraphQL plugin
         * to activate the extension.
         */
        $gatoGraphQLPluginVersionConstraint = '^1.0';
        
        /**
         * Validate Gato GraphQL is active
         */
        if (!class_exists(Plugin::class)) {
            \add_action('admin_notices', function () use ($extensionName) {
                printf(
                    '<div class="notice notice-error"><p>%s</p></div>',
                    sprintf(
                        __('Plugin <strong>%s</strong> is not installed or activated. Without it, plugin <strong>%s</strong> will not be loaded.', 'gatographql-hello-dolly'),
                        __('Gato GraphQL', 'gatographql-hello-dolly'),
                        $extensionName
                    )
                );
            });
            return;
        }

        $extensionManager = PluginApp::getExtensionManager();

        if (!$extensionManager->assertIsValid(
            GatoGraphQLExtension::class,
            $extensionVersion,
            $extensionName,
            $gatoGraphQLPluginVersionConstraint
        )) {
            return;
        }

        // Unless this extension is included inside a bundle...
        if (!$extensionManager->isExtensionBundled(GatoGraphQLExtension::class))  {
            /**
             * @gatographql-extension-info
             * 
             * If the extension is an integration for some plugin (eg: WooCommerce,
             * Yoast SEO or, in this case, Hello Dolly), add below:
             * 
             * - the plugin's main file
             * - the minimum required version (via a Composer version constraint)
             * 
             * The code below will check that the plugin, with the needed version,
             * is installed and activated. If it is not, the extension will not be loaded.
             *
             * @see https://getcomposer.org/doc/articles/versions.md#writing-version-constraints
             *
             * ------------------------------------------------------------
             * 
             * Validate the Hello Dolly plugin is active and satisfy
             * the required version constraint
             */
            $requiredPluginFile = 'hello-dolly/hello.php';
            $requiredPluginVersion = '^1.7';
            $isWordPressPluginActive = PluginStaticHelpers::isWordPressPluginActive($requiredPluginFile);
            if (!$isWordPressPluginActive
                || !PluginStaticHelpers::doesActivePluginSatisfyVersionConstraint(
                    $requiredPluginFile,
                    $requiredPluginVersion
                )
            ) {
                /**
                 * Register the depended-upon plugin main file, so that
                 * once this is activated, the container is regenerated
                 */
                $extensionManager->registerInactiveExtensionDependedUponPluginFiles([
                    $requiredPluginFile,
                ]);
                \add_action('admin_notices', function () use ($extensionName, $isWordPressPluginActive, $requiredPluginVersion) {
                    /**
                     * @gatographql-extension-info
                     * 
                     * If the extension is an integration for some plugin (eg: WooCommerce,
                     * Yoast SEO or, in this case, Hello Dolly), indicate the plugin's name:
                     */
                    $requiredPluginName = __('Hello Dolly', 'gatographql-hello-dolly');
                    printf(
                        '<div class="notice notice-error"><p>%s</p></div>',
                        $isWordPressPluginActive
                            ? sprintf(
                                __('Installed version of plugin <strong>%s</strong> does not satisfy required constraint <code>%s</code>. Plugin <strong>%s</strong> has not been loaded.', 'gatographql-hello-dolly'),
                                $requiredPluginName,
                                $requiredPluginVersion,
                                $extensionName
                            )
                            : sprintf(
                                __('Plugin <strong>%s</strong> is not installed or activated. Without it, plugin <strong>%s</strong> will not be loaded.', 'gatographql-hello-dolly'),
                                $requiredPluginName,
                                $extensionName
                            )
                    );
                });
                return;
            }
            
            // Load Composer’s autoloader
            require_once(__DIR__ . '/vendor/autoload.php');
        }

        /**
         * The commit hash is added to the plugin version 
         * through the CI when merging the PR.
         *
         * It is required to regenerate the container when
         * testing a generated .zip plugin without modifying
         * the plugin version.
         * (Otherwise, we'd have to @purge-cache.)
         *
         * Important: Do not modify this code!
         * It will be replaced in the CI to append "#{commit hash}"
         * when generating the plugin.
         *
         * @gatographql-readonly-code
         */
        $commitHash = null;

        // Create and set-up the extension instance
        $extensionManager->register(new GatoGraphQLExtension(
            __FILE__,
            $extensionVersion,
            $extensionName,
            $commitHash
        ))->setup();
    }
);
