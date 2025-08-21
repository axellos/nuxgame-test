FROM nginx:stable-alpine

ARG UID=1000
ARG GID=1000

RUN delgroup dialout \
    && addgroup -g ${GID} --system laravel \
    && adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel \
    && sed -i "s/user  nginx;/user laravel;/g" /etc/nginx/nginx.conf \
    && mkdir -p /var/www/html \
    && chown -R laravel:laravel /var/www/html

COPY ./default.conf /etc/nginx/conf.d/

WORKDIR /var/www/html
