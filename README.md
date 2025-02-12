🚀 Разворачивание проекта с Docker

Этот проект использует Docker для контейнеризации и PostgreSQL в качестве базы данных. Следуйте инструкциям ниже для быстрого развертывания.

📥 Клонирование репозитория

git clone git@github.com:KirSavickiy/PizzaHub.git
cd your-repository

⚙ Настройка окружения

Скопируйте файл конфигурации и укажите необходимые параметры:

cp .env.example .env

Редактируем .env и указываем:

APP_PORT – порт для приложения

DB_PORT – порт для базы данных

DB_USERNAME – логин для базы данных (по умолчанию: postgres)

DB_PASSWORD – пароль для базы данных (по умолчанию: root)

🛠 Сборка и запуск контейнеров

sudo docker compose up -d

📦 Установка зависимостей

sudo docker exec -it app composer install

🔑 Генерация ключа приложения

sudo docker exec -it app php artisan key:generate

🏗️ Миграция базы данных

sudo docker exec -it app php artisan migrate

🌱 Заполнение базы данных тестовыми данными

sudo docker exec -it app php artisan db:seed

После выполнения этой команды в папке postman будут сгенерированы файлы:

PizzaHubRestApi.postman_collection.json

Tokens.postman_environment.json

Эти файлы можно импортировать в Postman для удобного тестирования API.

📖 Доступ к документации

Документация API будет доступна по адресу:

localhost:порт/api/documentation

✅ Запуск тестов

sudo docker exec -it app php artisan test

🎉 Готово!

Теперь проект развернут и готов к работе! 🚀

