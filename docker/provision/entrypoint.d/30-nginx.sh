#!/usr/bin/env bash

# Replace markers
go-replace \
    -s "<APP_VERSION>" -r "$APP_VERSION" \
    --path=/opt/docker/etc/nginx/ \
    --path-pattern='*.conf' \
    --ignore-empty
