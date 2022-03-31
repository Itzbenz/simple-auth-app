FROM mysql:latest

ENV MYSQL_ALLOW_EMPTY_PASSWORD 1

#Get PHP
RUN apt-get update
RUN apt list | grep ^php
RUN apt -y install php
RUN apt -y install php-cli php-gd php-mysql php-pdo php-mbstring php-tokenizer php-bcmath php-xml php-fpm php-curl php-zip

#Install composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer


#Prepare stuff
COPY . .
RUN composer install

#Less goooo
EXPOSE 8000
ENTRYPOINT ["php", "artisan", "serve"]
