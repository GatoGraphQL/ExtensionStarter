#!/bin/sh
# Download and maybe activate external plugins
if wp plugin is-installed hello-dolly; then
    wp plugin activate hello-dolly
else
    wp plugin install hello-dolly --activate
fi

# Activate own plugins
wp plugin activate gatographql-hello-dolly

