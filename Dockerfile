FROM php:latest

#Install composer
RUN apt-get update
RUN apt -y install git
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer


#Prepare stuff
COPY . .
RUN composer install
RUN chmod +x ./run.sh

#Less goooo
EXPOSE 8000
ENTRYPOINT ["bash", "./run.sh"]
