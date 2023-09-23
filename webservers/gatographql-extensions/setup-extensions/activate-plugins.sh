#!/bin/sh
# Download and maybe activate external plugins
if wp plugin is-installed hello-dolly --path=/app/wordpress; then
    wp plugin activate hello-dolly --path=/app/wordpress
else
    wp plugin install hello-dolly --activate --path=/app/wordpress
fi

# Activate own plugins
wp plugin activate gatographql-hello-dolly --path=/app/wordpress

