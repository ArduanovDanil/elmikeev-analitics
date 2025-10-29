# Задача
Вам необходимо стянуть все данные по описанным эндпоинтам и сохранить в БД.

## Доступы к БД
URL: https://free21.beget.com/phpMyAdmin/db_structure.php?server=1&db=d91970m6_wp1  
Логин: d91970m6_wp1  
Пароль: pass_123_WORD

## Таблицы БД
incomes, orders, sales, stocks

## Запуск проекта
- Склонировать репозиторий
- Выполнить 
    ```
    docker run --rm \
    -u "$(id -u)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install
    ```
- Скопировать в корне проекта файл `.env.example` в `.env`
- Запустить приложение командой `./vendor/bin/sail up`
- Создать ключ приложения через `./vendor/bin/sail artisan key:generate`
- Запустить миграции `./vendor/bin/sail artisan migrate`
- Запустить заполнение БД `./vendor/bin/sail artisan db:seed`