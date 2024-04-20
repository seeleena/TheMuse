#!/bin/bash

composer self-update
composer install
if [ -d "/sql" ]; then
    for file in /sql/*.sql; do
        echo "Importing SQL file: $file"
        mysql -u root -p mydatabase < "$file"
    done
fi