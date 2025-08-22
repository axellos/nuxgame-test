FROM php:8.4-fpm-alpine

ARG UID=1000
ARG GID=1000

ARG WITH_XDEBUG=false

WORKDIR /var/www/html

RUN apk add --no-cache --update linux-headers icu-dev make \
    && docker-php-ext-install pdo pdo_mysql bcmath intl pcntl

RUN mkdir -p /usr/src/php/ext/redis  \
    && curl -fsSL https://pecl.php.net/get/redis | tar xvz -C "/usr/src/php/ext/redis" --strip 1 \
    && docker-php-ext-install redis

RUN if [ "$WITH_XDEBUG" = "true" ]; then \
      mkdir -p /usr/src/php/ext/xdebug \
      && curl -fsSL https://pecl.php.net/get/xdebug \
         | tar xvz -C "/usr/src/php/ext/xdebug" --strip 1 \
      && docker-php-ext-install xdebug \
      && cp ./90-xdebug.ini ${PHP_INI_DIR}/conf.d/ ; \
    fi

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN addgroup -g ${GID} --system laravel \
    && adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel \
    && sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf \
    && echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

USER laravel

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
