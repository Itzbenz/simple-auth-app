# How to run
- ~~use your leg~~
- `apt -y install php8.0 php8.0-{cli,gd,mysql,pdo,mbstring,tokenizer,bcmath,xml,fpm,curl,zip}` or download these extensions
- `composer install`
- `docker-compose up`

or

- modify docker to do in the ENTRYPOINT `composer install`
- `docker-compose up`
