<?php

namespace App\Http\Controllers\Swagger\Admin\Order;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/admin/orders",
 *     summary="Получить список заказов",
 *
 *     description="Возвращает список всех заказов пользователей. Требуется авторизация через Bearer Token с правами администратора.",
 *     operationId="getAllOrders",
 *     tags={"Admin - Orders"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Список заказов успешно получен",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="user_id", type="integer", example=1),
 *                     @OA\Property(property="status", type="string", example="processed"),
 *                     @OA\Property(property="delivery_method", type="string", example="pickup"),
 *                     @OA\Property(property="payment_method", type="string", example="online"),
 *                     @OA\Property(property="delivery_time", type="string", format="datetime", example="2025-02-12 16:46:06"),
 *                     @OA\Property(property="address", type="string", example="null"),
 *                 )
 *             ),
 *             @OA\Property(property="message", type="string", example="Orders retrieved successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Неавторизован",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthorized")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Доступ запрещен (пользователь не админ)",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Forbidden")
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/admin/orders/{id}/status",
 *     summary="Изменить статус заказа (Админ)",
 *     description="Позволяет администратору изменить статус заказа по его ID. Требуется авторизация через Bearer Token.",
 *     operationId="updateOrderStatus",
 *     tags={"Admin - Orders"},
 *     security={{"bearerAuth": {}}},
 *
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID заказа",
 *         @OA\Schema(type="integer", example=2)
 *     ),
 *
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"status"},
 *             @OA\Property(property="status", type="string", maxLength=50, example="Выполнен", description="Новый статус заказа"),
 *             @OA\Property(property="comment", type="string", maxLength=65535, example="Заказ был выполнен без задержек", nullable=true, description="Комментарий к изменению статуса")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Статус заказа успешно обновлен",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=2),
 *                 @OA\Property(property="user_id", type="integer", example=2),
 *                 @OA\Property(property="status", type="string", example="Выполнен"),
 *                 @OA\Property(property="delivery_method", type="string", example="pickup"),
 *                 @OA\Property(property="payment_method", type="string", example="online"),
 *                 @OA\Property(property="delivery_time", type="string", format="date-time", example="2025-02-13 07:46:20"),
 *                 @OA\Property(property="address", type="object", nullable=true)
 *             ),
 *             @OA\Property(property="message", type="string", example="Order status has been successfully changed.")
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
 *         description="Ошибка валидации",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Validation failed"),
 *             @OA\Property(property="code", type="integer", example=422),
 *             @OA\Property(property="details", type="object",
 *                 @OA\Property(property="status", type="array",
 *                     @OA\Items(type="string", example="The status field is required.")
 *                 ),
 *                 @OA\Property(property="comment", type="array",
 *                     @OA\Items(type="string", example="The comment field must not exceed 65535 characters.")
 *                 )
 *             )
 *         )
 *     )
 * )
 */




class OrderController extends Controller
{
}
