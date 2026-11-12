#!/bin/sh
set -eu

php artisan config:clear
php artisan migrate --force
