#!/usr/bin/env bash

docker-service disable cron
docker-service disable laravel-worker

## Start services
exec /opt/docker/bin/service.d/supervisor.sh
