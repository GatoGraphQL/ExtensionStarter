<?php
/*
Plugin Name: Gato GraphQL - Extension Name
Plugin URI:
Description: Integration of plugin Extension Name with Gato GraphQL
Version: 1.1.0-dev
Requires at least: 5.4
Requires PHP: 8.1
Author: Leonardo Losoviz
License:
License URI:
Text Domain: gatographql-extension-name
Domain Path: /languages
*/

use ExtensionVendor\ExtensionName\GatoGraphQLExtension;
use GatoGraphQL\GatoGraphQL\Plugin;
use GatoGraphQL\GatoGraphQL\PluginApp;
use GatoGraphQL\GatoGraphQL\PluginStaticHelpers;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

\add_action('init', function (): void {
    load_plugin_textdomain('gatographql-extension-name', false, plugin_basename(__FILE__) . '/languages');
});

/**
 * Create and set-up the extension
 */
add_action(
    'plugins_loaded',
    function (): void {
        /**
         * Extension's name and version.
         *
         * Use a stability suffix as supported by Composer.
         *
         * @see https://getcomposer.org/doc/articles/versions.md#stabilities
         */
        $extensionVersion = '1.1.0-dev';
        $extensionName = \__('Gato GraphQL - Extension Name', 'gatographql-extension-name');
        $mainPluginVersionConstraint = '^1.1';
        
        /**
         * Validate Gato GraphQL is active
         */
        if (!class_exists(Plugin::class)) {
            \add_action('admin_notices', function () use ($extensionName) {
                _e(sprintf(
                    '<div class="notice notice-error"><p>%s</p></div>',
                    sprintf(
                        __('Plugin <strong>%s</strong> is not installed or activated. Without it, plugin <strong>%s</strong> will not be loaded.', 'gatographql-extension-name'),
                        __('Gato GraphQL', 'gatographql-extension-name'),
                        $extensionName
                    )
                ));
            });
            return;
        }

        $extensionManager = PluginApp::getExtensionManager();

        if (!$extensionManager->assertIsValid(
            GatoGraphQLExtension::class,
            $extensionVersion,
            $extensionName,
            $mainPluginVersionConstraint
        )) {
            return;
        }

        // Unless this extension is included inside a bundle...
        if (!$extensionManager->isExtensionBundled(GatoGraphQLExtension::class))  {
            /**
             * Validate the Extension Name plugin is active and satisfy
             * the required version constraint
             */
            $requiredPluginFile = 'extension-wordpress-plugin/extension-wordpress-plugin-php-filename.php';
            $requiredPluginVersion = 'extension-wordpress-plugin-constraint';
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
                    $pluginName = __('Extension Name', 'gatographql-extension-name');
                    _e(sprintf(
                        '<div class="notice notice-error"><p>%s</p></div>',
                        $isWordPressPluginActive
                            ? sprintf(
                                __('Installed version of plugin <strong>%s</strong> does not satisfy required constraint <code>%s</code>. Plugin <strong>%s</strong> has not been loaded.', 'gatographql-extension-name'),
                                $pluginName,
                                $requiredPluginVersion,
                                $extensionName
                            )
                            : sprintf(
                                __('Plugin <strong>%s</strong> is not installed or activated. Without it, plugin <strong>%s</strong> will not be loaded.', 'gatographql-extension-name'),
                                $pluginName,
                                $extensionName
                            )
                    ));
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
