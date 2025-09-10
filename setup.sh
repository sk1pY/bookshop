#!/bin/bash
echo "1. Копируем .env.example -> .env"
cp .env.example .env
sed -i 's/^#\s*\(DB_[A-Z_]*=.*\)/\1/' .env
echo "UID=1000" >> .env
echo "GID=1000" >> .env

echo "2. Настраиваем Mailpit"
sed -i '/^MAIL_MAILER=/c\MAIL_MAILER=smtp' .env
sed -i '/^MAIL_HOST=/c\MAIL_HOST=mailpit' .env
sed -i '/^MAIL_PORT=/c\MAIL_PORT=1025' .env
sed -i '/^MAIL_USERNAME=/c\MAIL_USERNAME=null' .env
sed -i '/^MAIL_PASSWORD=/c\MAIL_PASSWORD=null' .env
sed -i '/^MAIL_ENCRYPTION=/c\MAIL_ENCRYPTION=null' .env
sed -i '/^MAIL_FROM_ADDRESS=/c\MAIL_FROM_ADDRESS=demo@example.com' .env
sed -i '/^MAIL_FROM_NAME=/c\MAIL_FROM_NAME="Demo App"' .env

echo "3. Настраиваем MYSQL"
sed -i '/^DB_CONNECTION=/c\DB_CONNECTION=mysql' .env
sed -i '/^DB_HOST=/c\DB_HOST=mysql' .env
sed -i '/^DB_PORT=/c\DB_PORT=3306' .env
sed -i '/^DB_DATABASE=/c\DB_DATABASE=bookshop' .env
sed -i '/^DB_USERNAME=/c\DB_USERNAME=laravel' .env
sed -i '/^DB_PASSWORD=/c\DB_PASSWORD=root' .env

echo "4. Запускаем контейнеры Sail"
docker compose up -d

echo "5. Ждем запуска MySQL..."
until docker compose exec php nc -z -w 1 mysql 3306; do
    echo "Ожидание MySQL..."
    sleep 2
done

echo "6. Устанавливаем зависимости Composer"
docker compose exec composer git config --global --add safe.directory /var/www/laravel
docker compose exec composer composer install --no-interaction

#echo "7. Устанавливаем права"
#docker compose exec php mkdir -p storage/logs bootstrap/cache
#docker compose exec php chown -R www-data:www-data storage bootstrap/cache
#docker compose exec php chmod -R 775 storage bootstrap/cache

echo "8. Генерируем ключ приложения"
docker compose exec php php artisan key:generate

echo "9. миграции"
docker compose exec php php artisan migrate:fresh --force

echo "10. Сеем"
docker compose exec php php artisan db:seed

echo "11. Создаем символическую ссылку для storage"
docker compose exec php php artisan storage:link

echo "12. Устанавливаем зависимости npm"
docker compose exec node npm install

echo "13. Собираем (Vite)"
docker compose exec node npm run build







