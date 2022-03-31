FROM php:latest

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer
RUN apt install mariadb-server
RUN mysql -u root -e "create database laravel"; 
RUN git clone https://github.com/Itzbenz/simple-auth-app.git \
    && cd simple-auth-app \
    && composer install \
RUN cd simple-auth-app && php artisan migrate:fresh

EXPOSE 8000

ENTRYPOINT ["php", "artisan", "serve"]