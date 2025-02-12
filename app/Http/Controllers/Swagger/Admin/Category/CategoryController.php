<?php

namespace App\Http\Controllers\Swagger\Admin\Category;

use App\Http\Controllers\Controller;

/**
 * @OA\Post(
 *     path="/api/admin/categories",
 *     summary="Создать новую категорию",
 *     description="Создает новую категорию. Требуется авторизация через Bearer Token с правами администратора.",
 *     operationId="createCategory",
 *     tags={"Admin - Categories"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name"},
 *             @OA\Property(property="name", type="string", maxLength=255, example="Лучшие пиццы 2025"),
 *             @OA\Property(property="description", type="string", maxLength=255, nullable=true, example="Категория с самыми вкусными пиццами")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Категория успешно создана",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=13),
 *                 @OA\Property(property="name", type="string", example="Лучшие пиццы 2025"),
 *                 @OA\Property(property="description", type="string", nullable=true, example="Категория с самыми вкусными пиццами")
 *             ),
 *             @OA\Property(property="message", type="string", example="New category created.")
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
 *                     @OA\Items(type="string", example="The name has already been taken.")
 *                 ),
 *                 @OA\Property(property="description", type="array",
 *                     @OA\Items(type="string", example="The description must not be greater than 255 characters.")
 *                 )
 *             )
 *         )
 *     )
 * )
 *
 * @OA\Put(
 *     path="/api/admin/categories/{category}",
 *     summary="Обновить категорию",
 *     description="Обновляет существующую категорию по ID. Требуется авторизация через Bearer Token с правами администратора.",
 *     operationId="updateCategory",
 *     tags={"Admin - Categories"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="category",
 *         in="path",
 *         required=true,
 *         description="ID категории",
 *         @OA\Schema(type="integer", example=13)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", maxLength=255, example="Обновленное название категории"),
 *             @OA\Property(property="description", type="string", maxLength=255, nullable=true, example="Новое описание категории")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Категория успешно обновлена",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Category updated successfully"),
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
 *                 @OA\Property(property="description", type="array",
 *                     @OA\Items(type="string", example="The description must not be greater than 255 characters.")
 *                 )
 *             )
 *         )
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/admin/categories/{category}",
 *     summary="Удалить категорию",
 *     description="Удаляет категорию по ID. Требуется авторизация через Bearer Token с правами администратора.",
 *     operationId="deleteCategory",
 *     tags={"Admin - Categories"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="category",
 *         in="path",
 *         required=true,
 *         description="ID категории",
 *         @OA\Schema(type="integer", example=13)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Категория успешно удалена",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="message", type="string", example="Category deleted successfully"),
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
 *         description="Категория не найдена",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="error"),
 *             @OA\Property(property="message", type="string", example="Category with ID 444 not found"),
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


class CategoryController extends Controller
{
}
