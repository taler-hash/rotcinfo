FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    libpq-dev \
    libexif-dev \
    && docker-php-ext-configure exif \
    && docker-php-ext-install exif \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql \
    && apt install npm -y \
    && apt-get clean


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer global require laravel/installer

RUN export PATH="$HOME/.composer/vendor/bin:$PATH"

WORKDIR /var/www/html/app

CMD ["php-fpm"]