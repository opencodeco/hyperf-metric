FROM 289208114389.dkr.ecr.us-east-1.amazonaws.com/picpay-dev/hyperf:php8.2-swoole5.0

ARG COMPOSER_AUTH
ENV COMPOSER_AUTH $COMPOSER_AUTH
COPY composer.* .
RUN composer install --prefer-dist --no-dev --optimize-autoloader

COPY . .
ENTRYPOINT [ "sh" ]

ARG APP_ENV="prod"
ENV APP_ENV $APP_ENV
RUN if [ "$APP_ENV" = "dev" ]; then \
    apk add php82-xdebug php82-pecl-pcov; \
    echo "opcache.enable=0" >> /etc/php82/conf.d/99_php.ini; \
fi