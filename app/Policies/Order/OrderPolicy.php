<?php

namespace App\Policies\Order;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user): bool
    {
        return $user->role()->where('name', 'admin')->exists();
    }

    public function viewOwnOrder(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }
}
