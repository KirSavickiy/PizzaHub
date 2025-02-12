<?php

namespace App\Http\Controllers\Swagger\Admin\Product;

use App\Http\Controllers\Controller;

/**
 * @OA\Post(
 *     path="/api/admin/products",
 *     summary="Создать новый продукт",
 *     description="Создаёт новый продукт. Можно создать продукт вместе с его разновидностями. Требуется авторизация через Bearer Token с правами администратора.",
 *     operationId="createProduct",
 *     tags={"Admin - Products"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "category_id"},
 *             @OA\Property(property="name", type="string", maxLength=255, example="Пицца 2026"),
 *             @OA\Property(property="description", type="string", nullable=true, maxLength=65535, example="Вкусная пицца с сыром"),
 *             @OA\Property(property="category_id", type="integer", example=6),
 *             @OA\Property(property="image_path", type="string", nullable=true, maxLength=255, example="images/products/pizza.jpg"),
 *             @OA\Property(
 *                 property="items",
 *                 type="array",
 *                 nullable=true,
 *                 @OA\Items(
 *                     @OA\Property(property="price", type="number", format="float", example=123.22),
 *                     @OA\Property(property="stock", type="integer", example=10),
 *                     @OA\Property(property="size", type="integer", nullable=true, example=null),
 *                     @OA\Property(property="dough_type", type="string", nullable=true, example=null)
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Продукт успешно создан",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=21),
 *                 @OA\Property(property="name", type="string", example="Пицца 2026"),
 *                 @OA\Property(property="description", type="string", nullable=true, example=null),
 *                 @OA\Property(property="image_path", type="string", nullable=true, example=null),
 *                 @OA\Property(property="category_id", type="integer", example=6),
 *                 @OA\Property(property="items", type="array",
 *                     @OA\Items(
 *                         @OA\Property(property="id", type="integer", example=21),
 *                         @OA\Property(property="price", type="number", format="float", example=123.22),
 *                         @OA\Property(property="stock", type="integer", example=10),
 *                         @OA\Property(property="size", type="integer", nullable=true, example=null),
 *                         @OA\Property(property="dough_type", type="string", nullable=true, example=null)
 *                     )
 *                 )
 *             ),
 *             @OA\Property(property="message", type="string", example="New product created.")
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
 *         response=403,
 *         description="Доступ запрещен (пользователь не админ)",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Forbidden")
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
 *                 @OA\Property(property="name", type="array",
 *                     @OA\Items(type="string", example="The name field is required.")
 *                 ),
 *                 @OA\Property(property="category_id", type="array",
 *                     @OA\Items(type="string", example="The category id field is required.")
 *                 )
 *             )
 *         )
 *     )
 * )
 *
 * @OA\Put(
 *     path="/api/admin/products/{product}",
 *     summary="Обновить информацию о продукте",
 *     description="Обновляет основные данные продукта (без изменений его разновидностей). Требуется авторизация через Bearer Token с правами администратора.",
 *     operationId="updateProduct",
 *     tags={"Admin - Products"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="product",
 *         in="path",
 *         required=true,
 *         description="ID продукта для обновления",
 *         @OA\Schema(type="integer", example=21)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "category_id"},
 *             @OA\Property(property="name", type="string", maxLength=255, example="Обновленная пицца 2026"),
 *             @OA\Property(property="description", type="string", nullable=true, maxLength=65535, example="Теперь с двойным сыром"),
 *             @OA\Property(property="category_id", type="integer", example=6),
 *             @OA\Property(property="image_path", type="string", nullable=true, maxLength=255, example="images/products/new_pizza.jpg"),
 *             @OA\Property(property="items", type="string", nullable=false, example=null, description="Поле запрещено для обновления")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Продукт успешно обновлен",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Product updated successfully"),
 *             @OA\Property(property="code", type="integer", example=200)
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
 *         response=403,
 *         description="Доступ запрещен (пользователь не админ)",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Forbidden")
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
 *                 @OA\Property(property="name", type="array",
 *                     @OA\Items(type="string", example="The name field is required.")
 *                 ),
 *                 @OA\Property(property="category_id", type="array",
 *                     @OA\Items(type="string", example="The category id field is required.")
 *                 )
 *             )
 *         )
 *     )
 * )
 *
 * @OA\Put(
 *     path="/api/admin/product/items/{item}",
 *     summary="Обновить разновидность продукта",
 *     description="Обновляет информацию о конкретной разновидности (item) продукта, такой как цена, количество на складе, размер и тип теста. Требуется авторизация через Bearer Token с правами администратора.",
 *     operationId="updateProductItem",
 *     tags={"Admin - Products"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="item",
 *         in="path",
 *         required=true,
 *         description="ID разновидности продукта для обновления",
 *         @OA\Schema(type="integer", example=45)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"price", "stock"},
 *             @OA\Property(property="price", type="number", format="float", example=199.99, description="Цена продукта"),
 *             @OA\Property(property="stock", type="integer", example=50, description="Количество продукта на складе"),
 *             @OA\Property(property="size", type="integer", nullable=true, example=30, description="Размер продукта (если есть)"),
 *             @OA\Property(property="dough_type", type="string", nullable=true, example="Тонкое", description="Тип теста (если есть)")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Разновидность продукта успешно обновлена",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Product updated successfully"),
 *             @OA\Property(property="code", type="integer", example=200)
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
 *         response=403,
 *         description="Доступ запрещен (пользователь не админ)",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Forbidden")
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
 *                 @OA\Property(property="price", type="array",
 *                     @OA\Items(type="string", example="The price field is required.")
 *                 ),
 *                 @OA\Property(property="stock", type="array",
 *                     @OA\Items(type="string", example="The stock field is required.")
 *                 )
 *             )
 *         )
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/admin/products/{product}",
 *     summary="Удалить продукт",
 *     description="Полностью удаляет продукт, включая все его разновидности (items). Требуется авторизация через Bearer Token с правами администратора.",
 *     operationId="deleteProduct",
 *     tags={"Admin - Products"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="product",
 *         in="path",
 *         required=true,
 *         description="ID продукта, который нужно удалить",
 *         @OA\Schema(type="integer", example=12)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Продукт успешно удален",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Product deleted successfully"),
 *             @OA\Property(property="code", type="integer", example=200)
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
 *         response=403,
 *         description="Доступ запрещен (пользователь не админ)",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Forbidden")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Продукт не найден",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Product with ID 555 not found"),
 *             @OA\Property(property="code", type="integer", example=404),
 *             @OA\Property(property="details", type="array", @OA\Items())
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
 *                 @OA\Property(property="id", type="array",
 *                     @OA\Items(type="string", example="The id field must be an integer.")
 *                 )
 *             )
 *         )
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/admin/product/items/{item}",
 *     summary="Удалить item продукта",
 *     description="Удаляет конкретный item продукта по его ID, при этом сам продукт остается в базе. Требуется авторизация через Bearer Token с правами администратора.",
 *     operationId="deleteProductItem",
 *     tags={"Admin - Products"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="item",
 *         in="path",
 *         required=true,
 *         description="ID item'а продукта, который нужно удалить",
 *         @OA\Schema(type="integer", example=21)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Item продукта успешно удален",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Product Item deleted successfully"),
 *             @OA\Property(property="code", type="integer", example=200)
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
 *         response=403,
 *         description="Доступ запрещен (пользователь не админ)",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Forbidden")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Item продукта не найден",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Product Item with ID 444 not found"),
 *             @OA\Property(property="code", type="integer", example=404),
 *             @OA\Property(property="details", type="array", @OA\Items())
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
 *                 @OA\Property(property="id", type="array",
 *                     @OA\Items(type="string", example="The id field must be an integer.")
 *                 )
 *             )
 *         )
 *     )
 * )
 */




class ProductController extends Controller
{

}
