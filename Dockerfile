# http://dockerfile.readthedocs.io/en/latest/content/DockerImages/dockerfiles/php-nginx.html
FROM webdevops/php-nginx:8.2

RUN docker-cronjob '* * * * * application /usr/local/bin/php /app/artisan schedule:run >> /dev/null 2>&1'

COPY vendor /app/vendor
COPY docker/etc /opt/docker/etc
COPY storage /app/storage
RUN chown -R 1000:1000 /app/storage
COPY bootstrap /app/bootstrap
RUN chown -R 1000:1000 /app/bootstrap/cache
COPY resources /app/resources
COPY config /app/config
COPY database /app/database
COPY routes /app/routes
COPY artisan *.* /app/
COPY *.* /app/
COPY app /app/app
COPY public /app/public

WORKDIR /app

VOLUME /app/storage

ARG APP_VERSION=latest
ENV FPM_PM_MAX_CHILDREN=32 \
    FPM_PM_START_SERVERS=10 \
    FPM_PM_MIN_SPARE_SERVERS=10 \
    FPM_PM_MAX_SPARE_SERVERS=20 \
    FPM_MAX_REQUESTS=400 \
    PHP_MAX_EXECUTION_TIME=50 \
    SERVICE_NGINX_CLIENT_MAX_BODY_SIZE=128M \
    PHP_UPLOAD_MAX_FILESIZE=128M \
    php.post_max_size=128M \
    php.request_slowlog_timeout=5s \
    php.apc.enable_cli=1 \
    php.opcache.validate_timestamps=0 \
    WEB_DOCUMENT_ROOT="/app/public" \
    REVERSE_PROXY_IP="*.*.*.*" \
    REVERSE_PROXY_HEADER_MULTI_VALUE=first \
    LOG_CHANNEL=syslog \
    APP_ENV=production \
    APP_DEBUG=false \
    APP_VERSION=$APP_VERSION

USER 1000
