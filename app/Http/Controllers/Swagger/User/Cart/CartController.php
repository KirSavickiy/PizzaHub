<?php

namespace App\Http\Controllers\Swagger\User\Cart;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/cart",
 *     summary="Получить корзину пользователя или гостевую корзину",
 *     description="Возвращает содержимое корзины. Если пользователь авторизован, используется его корзина. Если нет, нужно передать `cart-id` в параметрах запроса.",
 *     operationId="getCart",
 *     tags={"Cart"},
 *     @OA\Parameter(
 *         name="cart-id",
 *         in="query",
 *         description="ID гостевой корзины (если пользователь не авторизован)",
 *         required=false,
 *         @OA\Schema(
 *             type="string",
 *             format="uuid",
 *             example="5497a034-39c3-4d14-af0b-675f094926a1"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Корзина успешно получена",
 *         @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                     type="object",
 *                     @OA\Property(property="success", type="boolean", example=true),
 *                     @OA\Property(
 *                         property="data",
 *                         type="object",
 *                         @OA\Property(property="id", type="integer", example=1),
 *                         @OA\Property(property="session_id", type="string", nullable=true, example=null),
 *                         @OA\Property(property="user_id", type="integer", nullable=true, example=1),
 *                         @OA\Property(
 *                             property="items",
 *                             type="array",
 *                             @OA\Items(
 *                                 type="object",
 *                                 @OA\Property(property="id", type="integer", example=57),
 *                                 @OA\Property(property="product_id", type="integer", example=5),
 *                                 @OA\Property(property="name", type="string", example="Кантри-пицца"),
 *                                 @OA\Property(property="quantity", type="integer", example=2),
 *                                 @OA\Property(property="price", type="string", example="438.55"),
 *                                 @OA\Property(property="stock", type="integer", example=2),
 *                                 @OA\Property(property="dough_type", type="string", example="Тонкое"),
 *                                 @OA\Property(property="total_price", type="number", format="float", example=877.1)
 *                             )
 *                         )
 *                     ),
 *                     @OA\Property(property="total_price", type="number", format="float", example=877.1),
 *                     @OA\Property(property="message", type="string", example="Products retrieved successfully")
 *                 ),
 *                 @OA\Schema(
 *                     type="object",
 *                     @OA\Property(property="success", type="boolean", example=true),
 *                     @OA\Property(
 *                         property="data",
 *                         type="object",
 *                         @OA\Property(property="id", type="integer", example=33),
 *                         @OA\Property(property="session_id", type="string", example="5497a034-39c3-4d14-af0b-675f094926a1"),
 *                         @OA\Property(property="user_id", type="integer", nullable=true, example=null),
 *                         @OA\Property(property="items", type="array", @OA\Items(type="object"))
 *                     ),
 *                     @OA\Property(property="total_price", type="number", format="float", example=0),
 *                     @OA\Property(property="message", type="string", example="Products retrieved successfully")
 *                 )
 *             }
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Корзина не найдена или неверный `cart-id`",
 *         @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                     type="object",
 *                     @OA\Property(property="error", type="string", example="Cart not found")
 *                 ),
 *                 @OA\Schema(
 *                     type="object",
 *                     @OA\Property(property="status", type="string", example="error"),
 *                     @OA\Property(property="message", type="string", example="Cart not found for session ID 9ba4c140-fc7e-4720-86a5-0aa1fкак"),
 *                     @OA\Property(property="code", type="integer", example=404),
 *                     @OA\Property(property="details", type="array", @OA\Items(type="string"))
 *                 )
 *             }
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/cart",
 *     summary="Создать корзину для гостя",
 *     description="Создает новую гостевую корзину. Если пользователь авторизован, вернётся существующая корзина.",
 *     operationId="createCart",
 *     tags={"Cart"},
 *     @OA\Response(
 *         response=201,
 *         description="Новая корзина успешно создана (только для гостей)",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=35),
 *                 @OA\Property(property="session_id", type="string", example="f88cd52d-d042-47ae-a148-12256eb8e693"),
 *                 @OA\Property(property="user_id", type="integer", nullable=true, example=null)
 *             ),
 *             @OA\Property(property="total_price", type="number", format="float", example=0),
 *             @OA\Property(property="message", type="string", example="New cart created.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Корзина уже существует (для авторизованных пользователей)",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="session_id", type="string", nullable=true, example=null),
 *                 @OA\Property(property="user_id", type="integer", example=1),
 *                 @OA\Property(
 *                     property="items",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(property="id", type="integer", example=57),
 *                         @OA\Property(property="product_id", type="integer", example=5),
 *                         @OA\Property(property="name", type="string", example="Кантри-пицца"),
 *                         @OA\Property(property="quantity", type="integer", example=2),
 *                         @OA\Property(property="price", type="string", example="438.55"),
 *                         @OA\Property(property="stock", type="integer", example=2),
 *                         @OA\Property(property="dough_type", type="string", example="Тонкое"),
 *                         @OA\Property(property="total_price", type="number", format="float", example=877.1)
 *                     )
 *                 )
 *             ),
 *             @OA\Property(property="total_price", type="number", format="float", example=877.1),
 *             @OA\Property(property="message", type="string", example="Cart already exists.")
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/cart/add",
 *     summary="Добавить товар в корзину",
 *     description="Добавляет товар в корзину. Если запрос от гостя, необходимо передать параметр `cart-id`.",
 *     operationId="addToCart",
 *     tags={"Cart"},
 *     @OA\Parameter(
 *         name="cart-id",
 *         in="query",
 *         required=false,
 *         description="Идентификатор гостевой корзины (только для гостей)",
 *         @OA\Schema(type="string", example="b3296a2b-d6b6-46dc-b336-87d6df3a09bd")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"product_item_id"},
 *             @OA\Property(property="product_item_id", type="integer", example=4, description="ID товара, который нужно добавить в корзину")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Товар успешно добавлен в корзину",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="The product has been successfully added to your cart."),
 *             @OA\Property(
 *                 property="cart",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="session_id", type="string", nullable=true, example=null),
 *                 @OA\Property(property="items_count", type="integer", example=3),
 *                 @OA\Property(property="total_price", type="number", format="float", example=1422.83),
 *                 @OA\Property(
 *                     property="item",
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=58),
 *                     @OA\Property(property="product_id", type="integer", example=4),
 *                     @OA\Property(property="name", type="string", example="Чоризо фреш"),
 *                     @OA\Property(property="quantity", type="integer", example=1),
 *                     @OA\Property(property="price", type="string", example="545.73"),
 *                     @OA\Property(property="stock", type="integer", example=32),
 *                     @OA\Property(property="dough_type", type="string", example="Тонкое"),
 *                     @OA\Property(property="total_price", type="number", format="float", example=545.73)
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=409,
 *         description="Недостаточно товара на складе",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Товара: Кантри-пицца недостаточно на складе."),
 *             @OA\Property(property="code", type="integer", example=409),
 *             @OA\Property(
 *                 property="details",
 *                 type="object",
 *                 @OA\Property(property="stock", type="string", example="Доступный остаток на складе: 0.")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Корзина не найдена",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Cart not found for session ID b3296a2b-d6b6-46dc-b336-87d6df3a09bd"),
 *             @OA\Property(property="code", type="integer", example=404),
 *             @OA\Property(property="details", type="array", @OA\Items(type="string"))
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Ошибка валидации",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Validation error"),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 @OA\Property(property="product_item_id", type="array", @OA\Items(type="string", example="The product_item_id field is required."))
 *             )
 *         )
 *     )
 * )
 *
 * @OA\Put(
 *     path="/api/cart/update/{id}",
 *     summary="Обновить товар в корзине",
 *     description="Обновляет количество товара в корзине. Если запрос от гостя, необходимо передать параметр `cart-id`.",
 *     operationId="updateCartItem",
 *     tags={"Cart"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID товара в корзине",
 *         @OA\Schema(type="integer", example=58)
 *     ),
 *     @OA\Parameter(
 *         name="cart-id",
 *         in="query",
 *         required=false,
 *         description="Идентификатор гостевой корзины (только для гостей)",
 *         @OA\Schema(type="string", example="b3296a2b-d6b6-46dc-b336-87d6df3a09bd")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"quantity"},
 *             @OA\Property(property="quantity", type="integer", example=2, description="Новое количество товара в корзине")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Товар успешно обновлен в корзине",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="session_id", type="string", nullable=true, example=null),
 *                 @OA\Property(property="user_id", type="integer", example=1),
 *                 @OA\Property(
 *                     property="items",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(property="id", type="integer", example=58),
 *                         @OA\Property(property="product_id", type="integer", example=4),
 *                         @OA\Property(property="name", type="string", example="Чоризо фреш"),
 *                         @OA\Property(property="quantity", type="integer", example=1),
 *                         @OA\Property(property="price", type="string", example="545.73"),
 *                         @OA\Property(property="stock", type="integer", example=32),
 *                         @OA\Property(property="dough_type", type="string", example="Тонкое"),
 *                         @OA\Property(property="total_price", type="number", format="float", example=545.73)
 *                     )
 *                 )
 *             ),
 *             @OA\Property(property="total_price", type="number", format="float", example=984.28),
 *             @OA\Property(property="message", type="string", example="Product successfully updated in the cart.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=409,
 *         description="Недостаточно товара на складе",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Товара: Кантри-пицца недостаточно на складе."),
 *             @OA\Property(property="code", type="integer", example=409),
 *             @OA\Property(
 *                 property="details",
 *                 type="object",
 *                 @OA\Property(property="stock", type="string", example="Доступный остаток на складе: 1.")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Корзина не найдена",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Cart not found"),
 *             @OA\Property(property="code", type="integer", example=404),
 *             @OA\Property(property="details", type="array", @OA\Items(type="string"))
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Ошибка валидации",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Validation error"),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 @OA\Property(property="quantity", type="array", @OA\Items(type="string", example="The quantity field is required."))
 *             )
 *         )
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/cart/remove/{id}",
 *     summary="Удалить товар из корзины",
 *     description="Удаляет товар из корзины. Если запрос от гостя, необходимо передать параметр `cart-id`.",
 *     operationId="removeCartItem",
 *     tags={"Cart"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID товара в корзине",
 *         @OA\Schema(type="integer", example=58)
 *     ),
 *     @OA\Parameter(
 *         name="cart-id",
 *         in="query",
 *         required=false,
 *         description="Идентификатор гостевой корзины (только для гостей)",
 *         @OA\Schema(type="string", example="b3296a2b-d6b6-46dc-b336-87d6df3a09bd")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Товар успешно удален из корзины",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="session_id", type="string", nullable=true, example=null),
 *                 @OA\Property(property="user_id", type="integer", example=1),
 *                 @OA\Property(
 *                     property="items",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(property="id", type="integer", example=60),
 *                         @OA\Property(property="product_id", type="integer", example=6),
 *                         @OA\Property(property="name", type="string", example="Песто"),
 *                         @OA\Property(property="quantity", type="integer", example=5),
 *                         @OA\Property(property="price", type="string", example="247.46"),
 *                         @OA\Property(property="stock", type="integer", example=5),
 *                         @OA\Property(property="dough_type", type="string", example="Тонкое"),
 *                         @OA\Property(property="total_price", type="number", format="float", example=1237.3)
 *                     )
 *                 )
 *             ),
 *             @OA\Property(property="total_price", type="number", format="float", example=2745.43),
 *             @OA\Property(property="message", type="string", example="Product successfully removed from the cart.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Товар не найден в корзине",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Product with ID 5 not found in the Cart"),
 *             @OA\Property(property="code", type="integer", example=404),
 *             @OA\Property(property="details", type="array", @OA\Items(type="string"))
 *         )
 *     )
 * )
 */
class CartController extends Controller
{
}
