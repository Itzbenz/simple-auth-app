mysql -u "$DB_USERNAME" --password="$DB_PASSWORD" -h "$DB_HOST" -P "$DB_PORT" --protocol=tcp -e "CREATE DATABASE IF NOT EXISTS $DB_DATABASE;"
if [ ! -f init ]; then
    mysql -u "$DB_USERNAME" --password="$DB_PASSWORD" -h "$DB_HOST" -P "$DB_PORT" --protocol=tcp -e "CREATE DATABASE IF NOT EXISTS $DB_DATABASE;"
    php artisan migrate:fresh;
    php artisan db:seed;
    touch init;
fi
php artisan serve
