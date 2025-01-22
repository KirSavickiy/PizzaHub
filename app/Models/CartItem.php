<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_item_id',
        'quantity',
        'price',
    ];
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function productItem(): BelongsTo
    {
        return $this->belongsTo(ProductItem::class);
    }

}
