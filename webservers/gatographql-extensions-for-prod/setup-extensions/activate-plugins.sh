#!/bin/sh
# Download and maybe activate external plugins
if wp plugin is-installed hello-dolly; then
    wp plugin activate hello-dolly
else
    wp plugin install hello-dolly --activate
fi

# Activate own plugins
if wp plugin is-installed gatographql-hello-dolly; then
    wp plugin activate gatographql-hello-dolly
else
    ################################################################
    # @gatographql-extension-info
    # 
    # This server is for doing integration tests of the
    # plugin generated for PROD (when creating a new Release
    # in the GitHub repo).
    #
    # Once the plugin has been generated (it will be attached
    # as artifact in the Release page), download it and install
    # it in this server, either manually or via WP-CLI:
    #
    #   wp plugin install https://github.com/GatoGraphQL/ExtensionStarter/releases/latest/download/gatographql-hello-dolly-{MAJOR.MINOR.PATCH}.zip --force --activate
    #
    # (Replace "{MAJOR.MINOR.PATCH}" with the plugin version, eg: "1.10.0")
    #
    # You can also test the plugin generated for DEV, i.e.
    # the one attached to the `generate_plugins` workflow
    # from in GitHub Actions when merging a PR. Download the
    # plugin zip file from the "Summary" entry:
    #
    # @see https://github.com/GatoGraphQL/ExtensionStarter/actions/workflows/generate_plugins.yml
    #
    ################################################################
    echo "Please download the latest PROD version of the 'Gato GraphQL - Hello Dolly' plugin from your GitHub repo, and install it on this WordPress site"
fi

