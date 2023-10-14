FROM hyperf/hyperf:8.2-alpine-v3.18-swoole-v5.0

ARG timezone

ENV TIMEZONE=${timezone:-"Asia/Shanghai"} \
    APP_ENV=prod \
    SCAN_CACHEABLE=(true)

RUN set -ex \
    && apk add --no-cache php82-pecl-xdebug \
    && cd /etc/php82 \
    && { \
        echo "upload_max_filesize=128M"; \
        echo "post_max_size=128M"; \
        echo "memory_limit=1G"; \
        echo "date.timezone=${TIMEZONE}"; \
    } | tee conf.d/99_overrides.ini \
    && { \
        echo "zend_extension=xdebug.so"; \
        echo "xdebug.mode=coverage"; \
    } | tee conf.d/50_xdebug.ini \
    && { \
        echo "zend_extension=opcache"; \
        echo "opcache.enable=1"; \
        echo "opcache.enable_cli=1"; \
        echo "opcache.validate_timestamps=0"; \
        echo "opcache.use_cwd=0"; \
        echo "opcache.log_verbosity_level=2"; \
    } | tee conf.d/00_opcache.ini \
    && { \
        echo "extension=swoole.so"; \
        echo "swoole.use_shortname=0"; \
        echo "swoole.enable_preemptive_scheduler=1"; \
    } | tee conf.d/50_swoole.ini \
    && ln -sf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone \
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man \
    && echo -e "\033[42;37m Build Completed :).\033[0m\n"

WORKDIR /opt/www

COPY ./composer.* /opt/www/
RUN composer install --prefer-dist --no-dev --optimize-autoloader

COPY . /opt/www

ENTRYPOINT ["sh"]
