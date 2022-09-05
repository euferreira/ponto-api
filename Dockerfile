FROM php:7.4-cli AS ponto-image

RUN apt-get update && \
    apt-get install libzip-dev -y && \
    docker-php-ext-install zip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');"

WORKDIR /var/www

COPY . .

ENTRYPOINT [ "php", "-S", "0.0.0.0:8000", "-t", "public" ]

