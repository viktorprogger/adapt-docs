FROM php:rc-fpm-alpine

RUN apk --update add \
        oniguruma-dev && \
    docker-php-ext-install \
        mbstring \
        opcache && \
    apk add --no-cache tzdata && \
    set -ex

# Configure version constraints
ENV VERSION_PRESTISSIMO_PLUGIN=^0.3.0 \
    COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer global require --optimize-autoloader \
        "hirak/prestissimo:${VERSION_PRESTISSIMO_PLUGIN}" && \
    composer global dumpautoload --optimize

# xdebug
ENV XDEBUG_VERSION 2.8.0beta1
RUN apk --no-cache add --virtual .build-deps \
        g++ \
        autoconf \
        make && \
    pecl install xdebug-$XDEBUG_VERSION && \
    docker-php-ext-enable xdebug && \
    apk del .build-deps && \
    rm -r /tmp/pear/*

WORKDIR /var/www
RUN rm -rf ./* && \
    addgroup -g 1000 appuser && \
    adduser -D -u 1000 -G appuser appuser && \
    chown -R appuser:appuser .
USER appuser

COPY composer.* /var/www/
RUN composer install

COPY . /var/www/
