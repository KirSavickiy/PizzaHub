<?php

namespace App\Exceptions\Category;

use App\Exceptions\BaseException;

class CategoryNotFoundException extends BaseException
{
    public function __construct(int $productId = null, string $message = 'Category not found', int $code = 404)
    {
        if ($productId) {
            $message = "Category with ID {$productId} not found";
        }

        parent::__construct($message, $code);
    }
}
