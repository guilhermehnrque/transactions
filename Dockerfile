FROM php:8.1-apache-buster

RUN apt-get update && apt-get install -y \
            git \
            zsh \
            libfreetype6-dev \
            libjpeg62-turbo-dev \
            libpng-dev \
            libzip-dev \
        && docker-php-ext-install pdo pdo_mysql \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
        && docker-php-ext-install zip

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite

# RUN rm -rf /var/www/html && \
#     ln -s /app /var/www/html