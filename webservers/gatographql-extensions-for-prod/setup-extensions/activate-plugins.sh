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
    # wp plugin install https://github.com/GatoGraphQL/ExtensionStarter/releases/latest/download/gatographql-hello-dolly-{MAJOR.MINOR.PATCH}.zip --force --activate --path=/app/wordpress
    echo "Please download the latest PROD version of the 'Gato GraphQL - Hello Dolly' plugin from your GitHub repo, and install it on this WordPress site"
fi

