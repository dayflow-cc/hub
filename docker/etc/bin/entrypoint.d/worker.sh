#!/usr/bin/env bash

docker-service disable nginx
docker-service disable php-fpm
docker-service enable cron
[ -f /app/artisan ] && docker-service enable laravel-worker

## Start services
exec /opt/docker/bin/service.d/supervisor.sh
