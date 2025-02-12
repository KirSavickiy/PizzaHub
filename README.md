# 🚀 Разворачивание проекта с Docker

Этот проект использует **Docker** для контейнеризации и **PostgreSQL** в качестве базы данных. Следуйте инструкциям ниже для быстрого развертывания.

## 🛠️ Установка и настройка

### 1. Клонируем репозиторий
git clone git@github.com:KirSavickiy/PizzaHub.git
cd your-repository

### 2. Создаем файл окружения и настраиваем его
cp .env.example .env
В файле .env указываем:
- APP_PORT – порт для приложения
- DB_PORT – порт для базы данных
- DB_USERNAME – логин для базы данных (по умолчанию: postgres)
- DB_PASSWORD – пароль для базы данных (по умолчанию: root)

### 3. Собираем и запускаем контейнеры
sudo docker compose up -d

### 4. Устанавливаем зависимости
sudo docker exec -it app composer install

### 5. Генерируем ключ приложения
sudo docker exec -it app php artisan key:generate

### 6. Выполняем миграции
sudo docker exec -it app php artisan migrate

### 7. Заполняем базу тестовыми данными
sudo docker exec -it app php artisan db:seed

### После выполнения команды db:seed в папке postman будут сгенерированы файлы:
- postman/PizzaHubRestApi.postman_collection.json – коллекция запросов API
- postman/Tokens.postman_environment.json – окружение для Postman

Эти файлы можно импортировать в Postman для удобного тестирования API.

### 8. Доступ к документации API
 Документация будет доступна по адресу:
 http://localhost:<порт>/api/documentation

### 9. Запуск тестов
sudo docker exec -it app php artisan test
