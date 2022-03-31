FROM debian:stretch

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

#Install php
RUN apt-get update
RUN apt -y install php7.3
RUN apt -y install php7.3-cli php7.3-gd php7.3-mysql php7.3-pdo php7.3-mbstring php7.3-tokenizer php7.3-bcmath php7.3-xml php7.3-fpm php7.3-curl php7.3-zip


#Install composer
RUN apt -y install git default-mysql-client curl
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer


#Prepare stuff
COPY . .
RUN composer install
RUN chmod +x ./run.sh

#Less goooo
EXPOSE 8000
ENTRYPOINT ["bash", "./run.sh"]
