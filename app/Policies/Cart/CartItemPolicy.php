<?php

namespace App\Policies\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartItemPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CartItem $cartItem): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User|null $user, Cart $cart, CartItem $cartItem): bool
    {
        return $cartItem->cart_id === $cart->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User|null $user, Cart $cart, CartItem $cartItem): bool
    {
        return $cartItem->cart_id === $cart->id;
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CartItem $cartItem): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CartItem $cartItem): bool
    {
        return false;
    }
}
