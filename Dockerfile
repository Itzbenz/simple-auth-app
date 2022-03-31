FROM mysql:latest

ENV MYSQL_ALLOW_EMPTY_PASSWORD 1

#Get PHP
RUN apt-get update
RUN apt -y install php-8.1 php-8.1{cli,gd,mysql,pdo,mbstring,tokenizer,bcmath,xml,fpm,curl,zip}

#Make database
RUN mysql -u root -e "create database laravel";

#Install composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer

#Copy Code
COPY . .
#Prepare stuff
RUN composer install
RUN php artisan migrate:fresh

#Less goooo
EXPOSE 8000

ENTRYPOINT ["php", "artisan", "serve"]