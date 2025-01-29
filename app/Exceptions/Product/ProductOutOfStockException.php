<?php

namespace App\Exceptions\Product;

use App\Exceptions\BaseException;

class ProductOutOfStockException extends BaseException
{
    protected array $details;
    public function __construct(string $productName, int $stock)
    {
        $message = "Товара: $productName недостаточно на складе.";
        $this->details = [
            "stock" => "Доступный остаток на складе: $stock.",
        ];
        $this->setDetails($this->details);
        parent::__construct($message, 409);
    }

}
