<?php

namespace App\Http\Controllers\Swagger\User\Order;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/orders",
 *     summary="Получить заказы текущего пользователя",
 *     description="Возвращает список всех заказов, принадлежащих аутентифицированному пользователю.",
 *     operationId="getUserOrders",
 *     tags={"Orders"},
 *     security={{ "bearerAuth": {} }},
 *     @OA\Response(
 *         response=200,
 *         description="Список заказов успешно получен",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="user_id", type="integer", example=1),
 *                     @OA\Property(property="status", type="string", example="processed"),
 *                     @OA\Property(property="delivery_method", type="string", example="pickup"),
 *                     @OA\Property(property="payment_method", type="string", example="cash"),
 *                     @OA\Property(property="delivery_time", type="string", format="datetime", example="2025-02-15 04:13:59"),
 *                     @OA\Property (property="address", type="object", nullable="true",
 *                         @OA\Property(property="id", type="integer", example=6),
 *                         @OA\Property(property="address", type="string", example="96483 Gwendolyn Avenue Apt. 487"),
 *                         @OA\Property(property="city", type="string", example="Port Sharon"),
 *                     )
 *             )
 * ),
 *             @OA\Property(property="message", type="string", example="Orders retrieved successfully")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Неавторизованный доступ",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Unauthorized")
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/orders",
 *     summary="Создание заказа для текущего пользователя",
 *     description="Создает заказ. Требуется авторизация через Bearer Token. Корзина не должна быть пустой. После успешного создания заказа корзина автоматически очищается.",
 *     operationId="createOrder",
 *     tags={"Orders"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"delivery_method", "payment_method", "delivery_time"},
 *             @OA\Property(property="delivery_method", type="string", enum={"pickup", "delivery"}, example="pickup"),
 *             @OA\Property(property="payment_method", type="string", enum={"cash", "card", "online"}, example="cash"),
 *             @OA\Property(property="delivery_time", type="string", format="date-time", example="2025-01-31 15:00:00"),
 *             @OA\Property(property="address_id", type="integer", nullable=true, example=null)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Заказ успешно создан. Корзина очищена.",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Order successfully created. Cart has been cleared."),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=29),
 *                 @OA\Property(property="user_id", type="integer", example=1),
 *                 @OA\Property(property="status", type="string", example="new"),
 *                 @OA\Property(property="delivery_method", type="string", example="pickup"),
 *                 @OA\Property(property="payment_method", type="string", example="cash"),
 *                 @OA\Property(property="delivery_time", type="string", example="2025-01-31 15:00:00"),
 *                 @OA\Property(property="address", type="string", example="null"),
 *                 @OA\Property(property="items", type="array",
 *                     @OA\Items(
 *                         @OA\Property(property="id", type="integer", example=99),
 *                         @OA\Property(property="name", type="string", example="Чоризо фреш"),
 *                         @OA\Property(property="size", type="integer", example=20),
 *                         @OA\Property(property="dough_type", type="string", example="Тонкое"),
 *                         @OA\Property(property="quantity", type="integer", example=1),
 *                         @OA\Property(property="price", type="string", example="815.50")
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Ошибка: Корзина пуста",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Cart is empty"),
 *             @OA\Property(property="code", type="integer", example=400),
 *             @OA\Property(property="details", type="array", @OA\Items(type="string"))
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Ошибка валидации",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Validation failed"),
 *             @OA\Property(property="code", type="integer", example=422),
 *             @OA\Property(property="details", type="object",
 *                 @OA\Property(property="delivery_method", type="array",
 *                     @OA\Items(type="string", example="The delivery method field is required.")
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Неавторизован",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Unauthorized"),
 *             @OA\Property(property="code", type="integer", example=401)
 *         )
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/orders/{order}",
 *     summary="Получить заказ по ID",
 *     description="Возвращает заказ по ID для текущего пользователя. Требуется авторизация через Bearer Token.",
 *     operationId="getOrderById",
 *     tags={"Orders"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="order",
 *         in="path",
 *         required=true,
 *         description="ID заказа",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Успешный ответ с данными заказа",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="user_id", type="integer", example=1),
 *                 @OA\Property(property="status", type="string", example="processed"),
 *                 @OA\Property(property="delivery_method", type="string", example="pickup"),
 *                 @OA\Property(property="payment_method", type="string", example="cash"),
 *                 @OA\Property(property="delivery_time", type="string", format="date-time", example="2025-02-15 04:13:59"),
 *                 @OA\Property(property="address", type="string", example="null"),
 *                 @OA\Property(property="items", type="array",
 *                     @OA\Items(
 *                         @OA\Property(property="id", type="integer", example=1),
 *                         @OA\Property(property="name", type="string", example="Aqua Minerale газ. 0,5 л."),
 *                         @OA\Property(property="size", type="integer", nullable=true, example=null),
 *                         @OA\Property(property="dough_type", type="string", nullable=true, example=null),
 *                         @OA\Property(property="quantity", type="integer", example=1),
 *                         @OA\Property(property="price", type="string", example="675.34")
 *                     )
 *                 )
 *             ),
 *             @OA\Property(property="message", type="string", example="Order retrieved successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Неавторизован",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Unauthorized"),
 *             @OA\Property(property="code", type="integer", example=401)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Заказ не найден",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Order with id 100 not found"),
 *             @OA\Property(property="code", type="integer", example=404),
 *             @OA\Property(property="details", type="array", @OA\Items(type="string"))
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Ошибка валидации (некорректный ID заказа)",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Validation failed"),
 *             @OA\Property(property="code", type="integer", example=422),
 *             @OA\Property(property="details", type="object",
 *                 @OA\Property(property="id", type="array",
 *                     @OA\Items(type="string", example="The id field must be an integer.")
 *                 )
 *             )
 *         )
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/orders/{order}",
 *     summary="Получить заказ по ID (Админ)",
 *     description="Возвращает информацию о заказе по его ID. Доступен только для администраторов. Требуется авторизация через Bearer Token.",
 *     operationId="getAdminOrderById",
 *     tags={"Admin - Orders"},
 *     security={{"bearerAuth": {}}},
 *
 *     @OA\Parameter(
 *         name="order",
 *         in="path",
 *         required=true,
 *         description="ID заказа",
 *         @OA\Schema(type="integer", example=5)
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Успешный ответ с данными заказа",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=5),
 *                 @OA\Property(property="user_id", type="integer", example=2),
 *                 @OA\Property(property="status", type="string", example="processed"),
 *                 @OA\Property(property="delivery_method", type="string", example="delivery"),
 *                 @OA\Property(property="payment_method", type="string", example="card"),
 *                 @OA\Property(property="delivery_time", type="string", format="date-time", example="2025-02-15 12:18:03"),
 *                 @OA\Property(property="address", type="object",
 *                     @OA\Property(property="id", type="integer", example=6),
 *                     @OA\Property(property="address", type="string", example="96483 Gwendolyn Avenue Apt. 487"),
 *                     @OA\Property(property="city", type="string", example="Port Sharon")
 *                 ),
 *                 @OA\Property(property="items", type="array",
 *                     @OA\Items(
 *                         @OA\Property(property="id", type="integer", example=14),
 *                         @OA\Property(property="name", type="string", example="Бефстроганов"),
 *                         @OA\Property(property="size", type="integer", example=30),
 *                         @OA\Property(property="dough_type", type="string", example="Традиционное"),
 *                         @OA\Property(property="quantity", type="integer", example=6),
 *                         @OA\Property(property="price", type="string", example="207.55")
 *                     )
 *                 )
 *             ),
 *             @OA\Property(property="message", type="string", example="Order retrieved successfully")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=403,
 *         description="Доступ запрещен (не админ)",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Forbidden")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Неавторизованный доступ",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthorized")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="Заказ не найден",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Order with id 500 not found"),
 *             @OA\Property(property="code", type="integer", example=404),
 *             @OA\Property(property="details", type="array", @OA\Items(type="string"))
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Ошибка валидации (некорректный ID заказа)",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Validation failed"),
 *             @OA\Property(property="code", type="integer", example=422),
 *             @OA\Property(property="details", type="object",
 *                 @OA\Property(property="id", type="array",
 *                     @OA\Items(type="string", example="The id field must be an integer.")
 *                 )
 *             )
 *         )
 *     )
 * )
 */


class OrderController extends Controller
{
}
