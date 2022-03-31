FROM php:latest

ARG DB_HOST=127.0.0.1
ARG DB_PORT=3306
ARG DB_USERNAME=root
ARG DB_PASSWORD=""
ARG DB_DATABASE=laravel

ENV DB_HOST $DB_HOST
ENV DB_PORT $DB_PORT
ENV DB_USERNAME $DB_USERNAME
ENV DB_PASSWORD $DB_PASSWORD
ENV DB_DATABASE $DB_DATABASE


#Install composer
RUN apt-get update
RUN apt -y install git default-mysql-client
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer


#Prepare stuff
COPY . .
RUN composer install
RUN chmod +x ./run.sh

#Less goooo
EXPOSE 8000
ENTRYPOINT ["bash", "./run.sh"]
