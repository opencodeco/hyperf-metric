FROM hyperf/hyperf:8.2-alpine-v3.18-swoole-v5.0.3

RUN set -ex \
    && apk add --no-cache php82-pecl-xdebug \
    && cd /etc/php82 \
    && { \
        echo "zend_extension=xdebug.so"; \
        echo "xdebug.mode=develop,debug,coverage"; \
        echo "xdebug.idekey=PHPSTORM"; \
    } | tee conf.d/50_xdebug.ini \
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man \
    && echo -e "\033[42;37m Build Completed :).\033[0m\n"

WORKDIR /opt/www

COPY ./composer.* /opt/www/
RUN composer install --prefer-dist --optimize-autoloader

COPY . /opt/www

ENTRYPOINT ["sh"]
