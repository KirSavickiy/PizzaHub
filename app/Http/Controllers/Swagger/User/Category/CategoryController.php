<?php

namespace App\Http\Controllers\Swagger\User\Category;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/categories",
 *     summary="Получить список категорий",
 *     description="Возвращает список категорий товаров. Авторизация не требуется.",
 *     operationId="getCategories",
 *     tags={"Categories"},
 *     @OA\Response(
 *         response=200,
 *         description="Успешный ответ с категориями",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Напитки"),
 *                     @OA\Property(
 *                         property="description",
 *                         type="string",
 *                         example="Non consequatur sunt quibusdam. Ipsam sed qui quia praesentium sequi. Commodi dicta ad aut sequi."
 *                     )
 *                 )
 *             ),
 *             @OA\Property(property="message", type="string", example="Products retrieved successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Ошибка сервера",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Internal Server Error")
 *         )
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/categories/{category}",
 *     summary="Получить информацию о категории",
 *     description="Возвращает данные категории и список товаров в ней. Авторизация не требуется.",
 *     operationId="getCategory",
 *     tags={"Categories"},
 *     @OA\Parameter(
 *         name="category",
 *         in="path",
 *         required=true,
 *         description="ID категории",
 *         @OA\Schema(type="integer", example=50)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Успешный ответ с данными категории",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=5),
 *                 @OA\Property(property="name", type="string", example="Закуски"),
 *                 @OA\Property(
 *                     property="description",
 *                     type="string",
 *                     example="Praesentium modi non tempora autem voluptatem officia. Excepturi autem optio voluptatum neque."
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="products",
 *                 type="array",
 *                 @OA\Items(type="object")
 *             ),
 *             @OA\Property(property="message", type="string", example="Product retrieved successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Категория не найдена",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="No query results for model [App\\Models\\Category] 50"
 *             ),
 *             @OA\Property(
 *                 property="exception",
 *                 type="string",
 *                 example="Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException"
 *             ),
 *             @OA\Property(
 *                 property="file",
 *                 type="string",
 *                 example="/var/www/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php"
 *             ),
 *             @OA\Property(
 *                 property="line",
 *                 type="integer",
 *                 example=636
 *             )
 *         )
 *     )
 * )
 */

class CategoryController extends Controller
{

}
