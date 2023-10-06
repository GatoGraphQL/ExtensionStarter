#!/bin/sh
# Download and maybe activate external plugins
if wp plugin is-installed hello-dolly --path=/app/wordpress; then
    wp plugin activate hello-dolly --path=/app/wordpress
else
    wp plugin install hello-dolly --activate --path=/app/wordpress
fi

# Activate own plugins
if wp plugin is-installed gatographql-hello-dolly --path=/app/wordpress; then
    wp plugin activate gatographql-hello-dolly --path=/app/wordpress
else
    ################################################################
    # @gatographql-extension-info
    # 
    # This server is for doing integration tests, testing the
    # plugin generated for PROD (when creating a new Release
    # in the GitHub repo).
    #
    # Once the plugin has been generated (it will be attached
    # as artifact in the Release page), download it and install
    # it in this server, either manually or via WP-CLI:
    #
    #   wp plugin install https://github.com/GatoGraphQL/ExtensionStarter/releases/latest/download/gatographql-hello-dolly-{MAJOR.MINOR.PATCH}.zip --force --activate --path=/app/wordpress
    #
    # (Replace "{MAJOR.MINOR.PATCH}" with the plugin version, eg: "1.10.0")
    #
    # You can also test the plugin generated for DEV, i.e.
    # the one attached to the `generate_plugins` workflow
    # from in GitHub Actions when merging a PR.
    #
    # However, notice that the version constraint for the
    # Gato GraphQL plugin will (most likely) fail!
    #
    # That's because the DEV version is always one step
    # ahead than the PROD version.
    #
    # For instance, the ongoing DEV version may be `1.1.0-dev`,
    # and the latest PROD version may be `1.0.10`.
    #
    # @see layers/GatoGraphQLForWP/plugins/hello-dolly/gatographql-hello-dolly.php
    #
    # Then, the constraint in the generated DEV plugin will be:
    #
    #   $mainPluginVersionConstraint = '^1.1';
    # 
    # And since the Gato GraphQL plugin has version 1.0.10, it will fail.
    # 
    # To fix this, either edit the plugin's file and adapt the version constraint, to:
    #
    #   $mainPluginVersionConstraint = '^1.0';
    # 
    # Or otherwise, install the latest DEV version of the Gato GraphQL
    # plugin (plus gatographql-testing and gatographql-testing-schema)
    # from the `generate_plugins` workflow in the GitHub repo:
    #
    # @see https://github.com/GatoGraphQL/GatoGraphQL/actions/workflows/generate_plugins.yml
    ################################################################
    echo "Please download the latest PROD version of the 'Gato GraphQL - Hello Dolly' plugin from your GitHub repo, and install it on this WordPress site"
fi

