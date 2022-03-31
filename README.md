# How to run
- ~~use your leg~~
- `apt -y install php php-{cli,gd,mysql,pdo,mbstring,tokenizer,bcmath,xml,fpm,curl,zip}` or download these extensions
- `composer install`
- `./vendor/bin/sail up`





```bash
sudo apt -y install php php-{cli,gd,mysql,pdo,mbstring,tokenizer,bcmath,xml,fpm,curl,zip}
curl -sS https://getcomposer.org/installer | php 
sudo mv composer.phar /usr/bin/composer
```
# Run
### Note
- have docker
- have docker-composer
- have git
- have php
- have composer
```bash
git clone https://github.com/Itzbenz/simple-auth-app.git
cd simple-auth-app
composer install
./vendor/bin/sail up
```
or

### Note
- have git
- have php
- have composer
- have mysql
```bash
git clone https://github.com/Itzbenz/simple-auth-app.git
cd simple-auth-app
composer install
php artisan migrate:fresh
php artisan serve
```
or

### Note
- have docker
```bash
docker run -p 3306:3306 -d -e MYSQL_ROOT_PASSWORD="root" -e MYSQL_ROOT_HOST="%" mysql:latest
docker run --network="host" itzbenz/simple-auth-app:latest
```
or

### Note
- have docker
```bash
docker build -t simple-auth-app .
docker run -p 3306:3306 -d -e MYSQL_ROOT_PASSWORD="root" -e MYSQL_ROOT_HOST="%" mysql:latest
docker run --network="host" simple-auth-app
```


