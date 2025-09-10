FROM composer:latest

WORKDIR /var/www/laravel

CMD ["tail", "-f", "/dev/null"]
