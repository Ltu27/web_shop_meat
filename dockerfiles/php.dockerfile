FROM php:8.2-fpm-alpine

ARG UID=1000
ARG GID=1000

ENV UID=${UID}
ENV GID=${GID}
ENV WEB_DIR=/var/www

WORKDIR $WEB_DIR

# Essentials
RUN echo "UTC" >> /etc/timezone

RUN apk update && apk upgrade && apk add --no-cache \
    vim \
    zip \
    unzip \
    curl \
    sqlite \
    bash \
    bash-completion \
    icu-dev \
    libsodium-dev \
    libzip-dev \
    linux-headers \
    autoconf \
    g++ \
    make

RUN addgroup -g ${GID} --system laravel
RUN adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel
RUN addgroup laravel www-data

RUN sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf

# Add php extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql sodium zip bcmath intl sockets

# Change max upload size
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini 
RUN echo "upload_max_filesize = 100M" >> /usr/local/etc/php/php.ini \
    && echo "post_max_size = 100M" >> /usr/local/etc/php/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --chown=laravel:laravel . /var/www/

USER laravel
#RUN composer install

EXPOSE 9000
CMD ["php-fpm"]

