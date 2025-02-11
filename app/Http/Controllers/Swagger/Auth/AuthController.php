<?php

namespace App\Http\Controllers\Swagger\Auth;

use App\Http\Controllers\Controller;

/**
 * @OA\Post(
 *     path="/api/login",
 *     summary="Авторизация пользователя",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Успешная авторизация",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=14),
 *                 @OA\Property(property="first_name", type="string", example="Kiryl"),
 *                 @OA\Property(property="last_name", type="string", nullable=true, example=null)
 *             ),
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Login successful"),
 *             @OA\Property(property="token", type="string", example="6|6zPcqgtchsCh1TAg5lA2DqCFOzzf2MIYHcOkpkKb613d21fb")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Ошибка авторизации",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Invalid credentials"),
 *             @OA\Property(property="code", type="integer", example=401),
 *             @OA\Property(property="details", type="array", @OA\Items())
 *         )
 *     )
 * )
 *
 *
 * @OA\Post(
 *     path="/api/register",
 *     summary="Регистрация пользователя",
 *     tags={"Auth"},
 *     @OA\RequestBody(
 *         required=true,
 *           @OA\JsonContent(
 *          @OA\Property(property="data", type="object",
 *              @OA\Property(property="id", type="integer", example=13),
 *              @OA\Property(property="first_name", type="string", example="Kiryl"),
 *             @OA\Property(property="last_name", type="string", nullable=true, example=null),
 *          ),
 *        @OA\Property(property="success", type="boolean", example=true),
 * *             @OA\Property(property="message", type="string", example="User registered successfully"),
 * *             @OA\Property(property="token", type="string", example="3|XMGVEM30roBDpfuJHgDP9kLcfN65WmqzvCbp23ev9e6e98b1")
 * *         )
 * *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Успешная регистрация",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=13),
 *                 @OA\Property(property="first_name", type="string", example="Kiryl"),
 *                 @OA\Property(property="last_name", type="string", nullable=true, example=null),
 *             ),
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="User registered successfully"),
 *             @OA\Property(property="token", type="string", example="3|XMGVEM30roBDpfuJHgDP9kLcfN65WmqzvCbp23ev9e6e98b1")
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
 *                 @OA\Property(property="email", type="array",
 *                     @OA\Items(type="string", example="Email already exists")
 *                 ),
 *                 @OA\Property(property="phone", type="array",
 *                     @OA\Items(type="string", example="Phone number already exists")
 *                 ),
 *                 @OA\Property(property="password", type="array",
 *                     @OA\Items(type="string", example="Password does not match")
 *                 )
 *             )
 *         )
 *     )
 * )
 * @OA\Post(
 *     path="/api/logout",
 *     summary="Выход пользователя",
 *     tags={"Auth"},
 *     security={{"sanctum": {}}},
 *     @OA\Response(
 *         response=200,
 *         description="Выход выполнен",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Successfully logged out")
 *         )
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/addresses/{address}",
 *     summary="Удалить адрес",
 *     description="Удаление адреса по его ID",
 *     operationId="deleteAddress",
 *     tags={"Addresses"},
 *     security={{"bearer_token": {}}},
 *     @OA\Parameter(
 *         name="address",
 *         in="path",
 *         description="ID адреса для удаления",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             example=2
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Адрес успешно удален",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="success",
 *                 type="boolean",
 *                 example=true
 *             ),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=24),
 *                     @OA\Property(property="address", type="string", example="Советская 1"),
 *                     @OA\Property(property="city", type="string", example="Москва")
 *                 ),
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=23),
 *                     @OA\Property(property="address", type="string", example="Мира 26"),
 *                     @OA\Property(property="city", type="string", example="Минск")
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Address with ID 2 deleted successfully."
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Адрес с таким ID не найден",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="error"
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Address with ID 21 not found"
 *             ),
 *             @OA\Property(
 *                 property="code",
 *                 type="integer",
 *                 example=404
 *             ),
 *             @OA\Property(
 *                 property="details",
 *                 type="array",
 *                 @OA\Items(type="string"),
 *                 example={"Details about the error"}
 *             )
 *         )
 *     )
 * )
 */

class AuthController extends Controller
{
    //
}
