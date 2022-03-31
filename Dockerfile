FROM php:latest

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer
RUN apt-get update
RUN apt -y install mariadb-server \
    && service mysql start \
    && mysql -u root -e "create database laravel";
RUN echo "[mysqld]" >> /etc/mysql/my.cnf
RUN echo "bind-address=0.0.0.0" >> /etc/mysql/my.cnf
RUN git clone https://github.com/Itzbenz/simple-auth-app.git \
    && cd simple-auth-app \
    && composer install \
RUN cd simple-auth-app && php artisan migrate:fresh

EXPOSE 8000

ENTRYPOINT ["php", "artisan", "serve"]