<?php

namespace App\Http\Controllers\Swagger\User\Address;

use App\Http\Controllers\Controller;

/**
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer"
 * )
 *
 * @OA\Get(
 *      path="/api/addresses",
 *      summary="Получить список адресов",
 *      security={{"bearerAuth":{}}},
 *      tags={"Addresses"},
 *      @OA\Response(
 *          response=200,
 *          description="Успешный ответ",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="success", type="boolean", example=true),
 *              @OA\Property(property="data", type="array",
 *                  @OA\Items(
 *                      @OA\Property(property="id", type="integer", example=1),
 *                      @OA\Property(property="address", type="string", example="Советская 1"),
 *                      @OA\Property(property="city", type="string", example="Москва")
 *                  )
 *              ),
 *              @OA\Property(property="message", type="string", example="Addresses retrieved successfully")
 *          )
 *      ),
 *      @OA\Response(response=401, description="Неавторизован")
 * )
 *
 * @OA\Post(
 *      path="/api/addresses",
 *      summary="Создать новый адрес",
 *      security={{"bearerAuth":{}}},
 *      tags={"Addresses"},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"address_line_1", "city"},
 *              @OA\Property(property="address_line_1", type="string", example="Советская 1"),
 *              @OA\Property(property="city", type="string", example="Москва")
 *          )
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Адрес создан",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="success", type="boolean", example=true),
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="id", type="integer", example=24),
 *                  @OA\Property(property="address", type="string", example="Советская 1"),
 *                  @OA\Property(property="city", type="string", example="Москва")
 *              ),
 *              @OA\Property(property="message", type="string", example="New address created.")
 *          )
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Ошибка валидации",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="status", type="string", example="error"),
 *              @OA\Property(property="message", type="string", example="Validation failed"),
 *              @OA\Property(property="code", type="integer", example=422),
 *              @OA\Property(property="details", type="object",
 *                  @OA\Property(property="address_line_1", type="string", example="The address line 1 field is required.")
 *              )
 *          )
 *      )
 * )
 *
 * @OA\Get(
 *      path="/api/addresses/{address}",
 *      summary="Получить адрес по ID",
 *      security={{"bearerAuth":{}}},
 *      tags={"Addresses"},
 *      @OA\Parameter(
 *          name="address",
 *          in="path",
 *          required=true,
 *          @OA\Schema(type="integer", example=3)
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Успешный ответ",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="success", type="boolean", example=true),
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="id", type="integer", example=3),
 *                  @OA\Property(property="address", type="string", example="Мира 25"),
 *                  @OA\Property(property="city", type="string", example="Минск")
 *              ),
 *              @OA\Property(property="message", type="string", example="Address retrieved successfully")
 *          )
 *      ),
 *      @OA\Response(response=404, description="Адрес не найден")
 * )
 *
 * @OA\Put(
 *     path="/api/addresses/{address}",
 *     summary="Обновить адрес",
 *     description="Обновление адреса по его ID",
 *     operationId="updateAddress",
 *     tags={"Addresses"},
 *     security={{"bearer_token": {}}},
 *     @OA\Parameter(
 *         name="address",
 *         in="path",
 *         description="ID адреса для обновления",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             example=23
 *         )
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 type="object",
 *                 required={"address_line_1", "city"},
 *                 @OA\Property(
 *                     property="address_line_1",
 *                     description="Адресная строка 1",
 *                     type="string",
 *                     maxLength=255,
 *                     example="Мира 25"
 *                 ),
 *                 @OA\Property(
 *                     property="city",
 *                     description="Город",
 *                     type="string",
 *                     maxLength=50,
 *                     example="Минск"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Адрес обновлен успешно",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="success",
 *                 type="boolean",
 *                 example=true
 *             ),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer",
 *                     example=23
 *                 ),
 *                 @OA\Property(
 *                     property="address",
 *                     type="string",
 *                     example="Мира 25"
 *                 ),
 *                 @OA\Property(
 *                     property="city",
 *                     type="string",
 *                     example="Минск"
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Addresses retrieved successfully"
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
 *                 example={"Ошибка 1", "Ошибка 2"}
 *             )
 *         )
 *     )
 * )
 */

class AddressController extends Controller
{
}
