FROM php:8.0.2-fpm

RUN apt-get update -y \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN touch /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 64M;" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "upload_max_filesize = 64M;" >> /usr/local/etc/php/conf.d/uploads.ini

COPY docker/web/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

WORKDIR /app
COPY . /app
RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000
