<?php

namespace App\Services\Order;

use App\Models\Order;

interface OrderServiceInterface
{
    public function createOrder(array $data): Order;
}