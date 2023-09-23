#!/bin/sh
if wp core is-installed --path=/app/wordpress; then
    echo "WordPress is already installed"
    exit
fi
/bin/sh /app/setup/activate-plugins.sh
