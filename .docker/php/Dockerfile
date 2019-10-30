FROM php:7.1-fpm-alpine

RUN apk --update add \
        git \
        curl \
        curl-dev \
        bash \
        bash-completion \
        freetype-dev \
        icu \
        icu-dev \
        libxml2-dev \
        libintl \
        libjpeg-turbo-dev \
        libpng-dev \
        mysql-client && \
    docker-php-ext-configure gd \
        --with-gd \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
        --with-png-dir=/usr/include/ && \
    docker-php-ext-install \
        zip \
        curl \
        exif \
        gd \
        iconv \
        intl \
        mbstring \
        opcache \
        pdo_mysql && \
    apk del \
        icu-dev \
        gcc \
        g++ && \
    apk add --no-cache tzdata && \
    set -ex && \
# imagick
    printf "\n%s\n%s" "@edge http://dl-cdn.alpinelinux.org/alpine/edge/main" "@testing http://dl-cdn.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories && \
    apk --update add imagemagick-dev@edge imagemagick@edge && \
    apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS libtool && \
    export CFLAGS="$PHP_CFLAGS" CPPFLAGS="$PHP_CPPFLAGS" LDFLAGS="$PHP_LDFLAGS" && \
    pecl install imagick-3.4.3 && \
    printf "\n%s" "extension=imagick.so" >> /usr/local/etc/php/php.ini

# Configure version constraints
ENV VERSION_PRESTISSIMO_PLUGIN=^0.3.0 \
    COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer global require --optimize-autoloader \
        "hirak/prestissimo:${VERSION_PRESTISSIMO_PLUGIN}" && \
    composer global dumpautoload --optimize

# xdebug
ENV XDEBUG_VERSION 2.6.1
RUN apk --no-cache add --virtual .build-deps \
        g++ \
        autoconf \
        make && \
    pecl install xdebug-$XDEBUG_VERSION && \
    docker-php-ext-enable xdebug && \
    apk del .build-deps && \
    rm -r /tmp/pear/* && \
    echo -e "xdebug.remote_port = 9000\n\
xdebug.idekey = \"PHPSTORM\"\n\
xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /var/www
RUN rm -rf ./* && \
    addgroup -g 1000 appuser && \
    adduser -D -u 1000 -G appuser appuser && \
    chown -R appuser:appuser .
USER appuser

COPY composer.* /var/www/
RUN composer install

COPY . /var/www/
