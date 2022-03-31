FROM php:latest

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer

RUN apt-get update
RUN apt -y install mariadb-server 
RUN mysql -u root -e "create database laravel";

#hack
RUN echo "[mysqld]" >> /etc/mysql/my.cnf
RUN echo "bind-address=0.0.0.0" >> /etc/mysql/my.cnf

COPY . .
RUN composer install
RUN php artisan migrate:fresh

EXPOSE 8000

ENTRYPOINT ["php", "artisan", "serve"]