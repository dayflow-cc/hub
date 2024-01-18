#!/usr/bin/env bash

[ -f /app/artisan ] && docker-service enable laravel-worker

## Start services
exec /opt/docker/bin/service.d/supervisor.sh
