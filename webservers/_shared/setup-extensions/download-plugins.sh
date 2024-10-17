#!/bin/bash
# Install own plugins
if ! wp plugin is-installed gatographql-hello-dolly; then
    wp plugin install https://github.com/GatoGraphQL/ExtensionStarter/releases/latest/download/gatographql-hello-dolly.zip --force
fi
