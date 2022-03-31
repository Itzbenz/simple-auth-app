FROM ubuntu:21.10
ENV DEBIAN_FRONTEND noninteractive

RUN apt -y install php php-{cli,gd,mysql,pdo,mbstring,tokenizer,bcmath,xml,fpm,curl,zip}
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer
RUN apt install mysql-server
RUN git clone https://github.com/Itzbenz/simple-auth-app.git \
    && cd simple-auth-app \
    && composer install \
RUN cd simple-auth-app && php artisan migrate:fresh

EXPOSE 8000

ENTRYPOINT ["php", "artisan", "serve"]