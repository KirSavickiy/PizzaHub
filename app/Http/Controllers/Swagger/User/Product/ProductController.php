<?php

namespace App\Http\Controllers\Swagger\User\Product;

use App\Http\Controllers\Controller;

/**
 * @OA\Get(
 *     path="/api/products",
 *     summary="Получить список продуктов",
 *     description="Возвращает список продуктов с возможностью пагинации.",
 *     operationId="getProducts",
 *     tags={"Products"},
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Номер страницы для пагинации",
 *         required=false,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Успешный ответ",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Баварская"),
 *                     @OA\Property(property="description", type="string", example="Описание продукта"),
 *                     @OA\Property(property="image_path", type="string", example="https://via.placeholder.com/640x480.png"),
 *                     @OA\Property(property="category_id", type="integer", example=8),
 *                     @OA\Property(property="items", type="array",
 *                         @OA\Items(type="object",
 *                             @OA\Property(property="id", type="integer", example=1),
 *                             @OA\Property(property="price", type="string", example="681.24"),
 *                             @OA\Property(property="stock", type="integer", example=66),
 *                             @OA\Property(property="size", type="integer", example=35),
 *                             @OA\Property(property="dough_type", type="string", example="Традиционное")
 *                         )
 *                     )
 *                 )
 *             ),
 *             @OA\Property(property="pagination", type="object",
 *                 @OA\Property(property="current_page", type="integer", example=1),
 *                 @OA\Property(property="last_page", type="integer", example=2),
 *                 @OA\Property(property="per_page", type="integer", example=15),
 *                 @OA\Property(property="total", type="integer", example=20)
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
 *     path="/api/products/{product}",
 *     summary="Получить информацию о продукте",
 *     tags={"Products"},
 *     @OA\Parameter(
 *         name="product",
 *         in="path",
 *         required=true,
 *         description="ID продукта",
 *         @OA\Schema(type="integer", example=5)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Успешный ответ",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=5),
 *                 @OA\Property(property="name", type="string", example="Кантри-пицца"),
 *                 @OA\Property(property="description", type="string", example="Velit et earum illum sit adipisci consequatur occaecati."),
 *                 @OA\Property(property="image_path", type="string", format="url", example="https://via.placeholder.com/640x480.png/0022ff?text=dolorem"),
 *                 @OA\Property(property="category_id", type="integer", example=8),
 *                 @OA\Property(
 *                     property="items",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(property="id", type="integer", example=5),
 *                         @OA\Property(property="price", type="string", example="438.55"),
 *                         @OA\Property(property="stock", type="integer", example=2),
 *                         @OA\Property(property="size", type="integer", example=20),
 *                         @OA\Property(property="dough_type", type="string", example="Тонкое")
 *                     )
 *                 )
 *             ),
 *             @OA\Property(property="message", type="string", example="Product retrieved successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Продукт не найден",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Product] 50"),
 *             @OA\Property(property="exception", type="string", example="Symfony\\Component\\HttpKernel\\Exception\\NotFoundHttpException"),
 *             @OA\Property(property="file", type="string", example="/var/www/vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/Handler.php"),
 *             @OA\Property(property="line", type="integer", example=636),
 *             @OA\Property(property="trace", type="array", @OA\Items(type="object"))
 *         )
 *     )
 * )
 */

class ProductController extends Controller
{
}
