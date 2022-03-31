mysql -u "$DB_USERNAME" -h "$DB_HOST":"$DB_PORT" --password="$DB_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS $DB_DATABASE;"
if [ ! -f init ]; then
    php artisan migrate:fresh;
    php artisan db:seed;
    touch init;
fi
php artisan serve
