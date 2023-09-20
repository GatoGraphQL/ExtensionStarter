#!/bin/sh
wp core install --url="gatographql-extension-name-for-prod.lndo.site" --title="Gato GraphQL for PROD (PHP 7.2 + Generated .zip plugins)" --admin_user=admin --admin_password=admin --admin_email=admin@example.com --path=/app/wordpress 
wp option update siteurl "https://gatographql-extension-name-for-prod.lndo.site" --path=/app/wordpress 
wp option update home "https://gatographql-extension-name-for-prod.lndo.site" --path=/app/wordpress 
# This change is needed on InstaWP
# wp option update admin_email "admin@example.com" --path=/app/wordpress
