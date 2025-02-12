# Разработка API для пиццерии

## Список задач для разработки

### 1. Создание сущности *User*

**Описание:**  
Представляет зарегистрированного клиента или администратора, обладающего уникальными учетными данными и связанного с ролью, заказами и адресами.

**БД и миграции:**  
Таблица `users` с полями:
- `id` (primary key)  
- `first_name` (string, required)  
- `last_name` (string, optional)  
- `email` (string, required, unique)  
- `phone` (string, required, unique)  
- `birth_date` (date, optional)  
- `password` (string, required)  
- `role_id` (integer, FK) — ссылка на роль пользователя (admin, client)

Создать сидеры для добавления тестовых данных: минимум 10 пользователей, включая 1 администратора с заранее заданным паролем.

**Функциональность API:**  
- `POST /register`: Регистрация нового пользователя.  
- `POST /login`: Авторизация.  
- `GET /profile`: Просмотр данных текущего пользователя.  
- `PUT /profile`: Обновление данных текущего пользователя.

---

### 2. Создание сущности *Product*

**Описание:**  
Товары пиццерии (пиццы и напитки).

**БД и миграции:**  
Таблица `products` с полями:  
- `id` (primary key)  
- `name` (string, required)  
- `description` (text, optional)  
- `category_id` (integer, FK на `categories.id`)  
- `image_path` (string, optional)

Таблица `product_items` с полями:  
- `id` (primary key)  
- `price` (decimal, required)  
- `stock` (integer, required) — остатки на складе  
- `size` (integer, optional) — размер для пиццы (или других продуктов)  
- `dough_type` (string, optional) — тип теста для пицц  
- `product_id` (integer, FK на `products.id`)

Создать сидеры для добавления тестовых данных: 20 тестовых товаров (10 пицц, 10 напитков).

**Функциональность API:**  
- `GET /products`: возвращает список всех товаров с их вариантами (product_items).  
- `GET /products/{id}`: возвращает информацию о товаре и его вариантах.

---

### 3. Создание сущности *Category*

**Описание:**  
Категории, к которым относятся товары пиццерии.

**БД и миграции:**  
Таблица `categories` с полями:  
- `id` (primary key)  
- `name` (string, required) — название категории, например, "Пиццы"  
- `description` (text, optional) — описание категории

**Сидеры:**  
- Напитки  
- Десерты  
- Соусы

**Функциональность API:**  
- `GET /categories`: Получение списка всех категорий.  
- `GET /categories/{id}`: Получение информации о конкретной категории, включая список товаров, принадлежащих ей.

---

### 4. Создание сущности *Cart*

**Описание:**  
Корзина для хранения выбранных пользователем товаров.

**БД и миграции:**  
Таблица `carts` с полями:  
- `id` (primary key)  
- `user_id` (FK на `users.id`)  
- `session_id` (string, уникальный идентификатор для гостей).

Таблица `cart_items` с полями:  
- `id` (primary key)  
- `cart_id` (FK на `carts.id`)  
- `product_item_id` (FK на `product_items.id`)  
- `quantity` (integer, required)  
- `price` (decimal, required)

**Функциональность API:**  
- `GET /cart`: Возвращает содержимое текущей корзины пользователя.  
  Если пользователь авторизован, корзина привязывается к `user_id`. Если пользователь гость, корзина идентифицируется по `session_id`.  
- `POST /cart/add`: Добавление товара в корзину. Если товар уже есть в корзине, увеличивает количество.  
- `PUT /cart/update/{item_id}`: Изменение количества товара в корзине. Если `quantity` равно нулю, можно вместо этого удалить товар через `DELETE`.  
- `DELETE /cart/remove/{item_id}`: Удаление товара из корзины.

---

### 5. Создание сущности *Address*

**Описание:**  
Адреса доставки пользователей.

**БД и миграции:**  
Таблица `addresses` с полями:  
- `id` (primary key)  
- `address_line_1` (string, required) — основная строка адреса.  
- `city` (string, required) — город доставки.  
- `user_id` (FK на `users.id`) — связь с пользователем.

**Функциональность API:**  
- `GET /addresses`: Получение списка всех адресов текущего пользователя.  
- `POST /addresses`: Создание адреса для текущего пользователя.  
- `PUT /addresses/{id}`: Обновление конкретного адреса.  
- `DELETE /addresses/{id}`: Удаление конкретного адреса.

---

### 6. Создание сущности *Order*

**Описание:**  
Оформление заказов пользователями.

**БД и миграции:**  
Таблица `orders` с полями:  
- `id` (primary key)  
- `user_id` (FK на `users.id`)  
- `delivery_method` (enum: pickup, delivery)  
- `payment_method` (enum: cash, card, online)  
- `delivery_time` (timestamp)  
- `total_price` (decimal)  
- `addresses_id` (FK на `addresses.id`, optional)

Таблица `order_items` с полями:  
- `id` (primary key)  
- `order_id` (FK на `orders.id`)  
- `product_item_id` (FK на `product_items.id`)  
- `quantity` (integer, required)  
- `price` (decimal, required)

**Функциональность API:**  
- `POST /orders`: Создание нового заказа.  
- `GET /orders`: Возвращает список всех заказов текущего пользователя.  
- `GET /orders/{id}`: Возвращает детальную информацию о конкретном заказе.

---

### 7. Работа со статусами заказов

**Описание:**  
Отслеживание и изменение статусов заказов.

**БД и миграции:**  
Таблица `order_status_histories` с полями:  
- `id` (primary key)  
- `order_id` (FK на `orders.id`) — идентификатор заказа.  
- `old_status` (string, required) — предыдущий статус.  
- `new_status` (string, required) — новый статус.  
- `comment` (text, optional) — комментарий изменения статуса.  
- `changed_by` (FK на `users.id`) — пользователь, изменивший статус.  
- `changed_at` (timestamp, default: NOW) — время изменения.

**Функциональность API:**  
- `GET /orders/{id}/status`: Получение текущего статуса заказа.  
- `POST /orders/{id}/status`: Изменение статуса заказа (доступно только администратору).

---

### 8. Выделение роутов для админ-панели

Маршруты будут сгруппированы под префиксом `/admin` и использовать middleware для проверки роли администратора.

**Функциональность API:**  
- `GET /admin/products`: Возвращает список всех товаров.  
- `POST /admin/products`: Создает новый товар с вариантами или без них.  
- `PUT /admin/products/{id}`: Редактирует основной товар без изменения вариантов.  
- `PUT /admin/products/{id}/items/{product_item_id}`: Редактирует конкретный вариант товара.  
- `DELETE /admin/products/{id}`: Удаляет товар и все его варианты.  
- `DELETE /products/{id}/items/{product_item_id}`: Удаляет конкретный вариант товара, сохраняя основной товар.  
- `POST /admin/categories`: Создание новой категории.  
- `PUT /admin/categories/{id}`: Обновление данных конкретной категории.  
- `DELETE /admin/categories/{id}`: Удаление категории (только если она не связана с товарами).  
- `GET /admin/orders`: Список всех заказов.  
- `GET /admin/orders/{id}`: Детальная информация о заказе.  
- `POST /admin/orders/{id}/status`: Изменение статуса заказа.
