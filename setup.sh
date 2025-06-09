#!/bin/bash
sail=./vendor/bin/sail

echo "1. Копируем .env.example -> .env"
cp .env.example .env
sed -i 's/^#\s*\(DB_[A-Z_]*=.*\)/\1/' .env

echo "2. Устанавливаем зависимости Composer"
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs

echo "3. Настраиваем Mailpit в .env"
sed -i '/^MAIL_MAILER=/c\MAIL_MAILER=smtp' .env
sed -i '/^MAIL_HOST=/c\MAIL_HOST=mailpit' .env
sed -i '/^MAIL_PORT=/c\MAIL_PORT=1025' .env
sed -i '/^MAIL_USERNAME=/c\MAIL_USERNAME=null' .env
sed -i '/^MAIL_PASSWORD=/c\MAIL_PASSWORD=null' .env
sed -i '/^MAIL_ENCRYPTION=/c\MAIL_ENCRYPTION=null' .env
sed -i '/^MAIL_FROM_ADDRESS=/c\MAIL_FROM_ADDRESS=demo@example.com' .env
sed -i '/^MAIL_FROM_NAME=/c\MAIL_FROM_NAME="Demo App"' .env

echo "4 Настройка БД"
sed -i '/^DB_CONNECTION=/c\DB_CONNECTION=mysql' .env
sed -i '/^DB_HOST=/c\DB_HOST=mysql' .env
sed -i '/^DB_PORT=/c\DB_PORT=3306' .env
sed -i '/^DB_DATABASE=/c\DB_DATABASE=bookshop' .env
sed -i '/^DB_USERNAME=/c\DB_USERNAME=root' .env
sed -i '/^DB_PASSWORD=/c\DB_PASSWORD=' .env


echo "5. Запускаем контейнеры Sail"
$sail up -d

echo "6. Устанавливаем зависимости npm"
$sail npm install

echo "7. Генерируем ключ приложения"
$sail artisan key:generate

echo "8. Собираем (Vite)"
$sail npm run build

echo "9. миграции"
$sail artisan migrate:fresh

echo "10. Сеем "
$sail artisan db:seed

echo "11. Создаем символическую ссылку для storage"
$sail artisan storage:link

