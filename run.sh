mysql -u root -e "CREATE DATABASE IF NOT EXISTS laravel;"
if [ ! -f init ]; then
    php artisan migrate:fresh;
    php artisan db:seed;
    touch init;
fi
php artisan serve
